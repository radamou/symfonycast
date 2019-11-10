<?php

namespace KnpU\Application;

use Doctrine\Common\Annotations\AnnotationReader;
use Hateoas\HateoasBuilder;
use Hateoas\UrlGenerator\SymfonyUrlGenerator;
use JMS\Serializer\Naming\IdenticalPropertyNamingStrategy;
use JMS\Serializer\SerializerBuilder;
use KnpU\Domain\Battle\BattleManager;
use KnpU\Domain\Battle\BattleRepository;
use KnpU\Domain\Battle\PowerManager;
use KnpU\Domain\Battle\TwigExtension\BattleExtension;
use KnpU\Domain\Common\RepositoryContainer;
use KnpU\Domain\Programmer\ProgrammerRepository;
use KnpU\Domain\Project\ProjectRepository;
use KnpU\Domain\User\UserRepository;
use KnpU\Infrastructure\Api\ApiProblem;
use KnpU\Infrastructure\Api\ApiProblemException;
use KnpU\Infrastructure\Api\ApiProblemResponseFactory;
use KnpU\Infrastructure\Security\Authentication\ApiEntryPoint;
use KnpU\Infrastructure\Security\Authentication\ApiTokenListener;
use KnpU\Infrastructure\Security\Authentication\ApiTokenProvider;
use KnpU\Infrastructure\Security\Token\ApiTokenRepository;
use KnpU\Infrastructure\Validator\ApiValidator;
use KnpU\Tests\DataFixtures\FixturesManager;
use Silex\Application as SilexApplication;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\SecurityServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Translation\Loader\YamlFileLoader;
use Symfony\Component\Validator\Mapping\ClassMetadataFactory;
use Symfony\Component\Validator\Mapping\Loader\AnnotationLoader;

class Application extends SilexApplication
{
    public function __construct(array $values = [])
    {
        parent::__construct($values);

        $this->configureParameters();
        $this->configureProviders();
        $this->configureServices();
        $this->configureSecurity();
        $this->configureListeners();
    }

    /**
     * Dynamically finds all *Controller.php files in the Controller directory,
     * instantiates them, and mounts their routes.
     *
     * This is done so we can easily create new controllers without worrying
     * about some of the Silex mechanisms to hook things together.
     */
    public function mountControllers()
    {
        $controllerPath = 'src/Application/Controller';
        $finder = new Finder();
        $finder->in($this['root_dir'].'/'.$controllerPath)
            ->name('*Controller.php')
        ;

        foreach ($finder as $file) {
            /** @var \Symfony\Component\Finder\SplFileInfo $file */
            // e.g. Api/FooController.php
            $cleanedPathName = $file->getRelativePathname();
            // e.g. Api\FooController.php
            $cleanedPathName = \str_replace('/', '\\', $cleanedPathName);
            // e.g. Api\FooController
            $cleanedPathName = \str_replace('.php', '', $cleanedPathName);

            $class = 'KnpU\\Application\\Controller\\'.$cleanedPathName;

            // don't instantiate the abstract base class
            $refl = new \ReflectionClass($class);

            if ($refl->isAbstract()) {
                continue;
            }

            $this->mount('/', new $class($this));
        }
    }

    private function configureProviders()
    {
        // URL generation
        $this->register(new UrlGeneratorServiceProvider());

        // Twig
        $this->register(new TwigServiceProvider(), [
            'twig.path' => $this['root_dir'].'/views',
        ]);
        $app['twig'] = $this->share($this->extend('twig', function (\Twig_Environment $twig, $app) {
            $twig->addExtension($app['twig.battle_extension']);

            return $twig;
        }));

        // Sessions
        $this->register(new SessionServiceProvider());

        // Doctrine DBAL
        $this->register(new DoctrineServiceProvider(), [
            'db.options' => [
                'driver' => 'pdo_sqlite',
                'path' => $this['sqlite_path'],
            ],
        ]);

        // Monolog
        $this->register(new MonologServiceProvider(), [
            'monolog.logfile' => $this['root_dir'].'/logs/development.log',
        ]);

        // Validation
        $this->register(new ValidatorServiceProvider());
        // configure validation to load from a YAML file
        $this['validator.mapping.class_metadata_factory'] = $this->share(function () {
            return new ClassMetadataFactory(
                new AnnotationLoader($this['annotation_reader'])
            );
        });

        // Translation
        $this->register(new TranslationServiceProvider(), [
            'locale_fallbacks' => ['en'],
        ]);
        $this['translator'] = $this->share($this->extend('translator', function ($translator) {
            /* @var \Symfony\Component\Translation\Translator $translator */
            $translator->addLoader('yaml', new YamlFileLoader());

            $translator->addResource('yaml', $this['root_dir'].'/translations/en.yml', 'en');

            return $translator;
        }));
    }

    private function configureParameters()
    {
        $this['root_dir'] = __DIR__.'/../../';
        $this['sqlite_path'] = $this['root_dir'].'/data/code_battles.sqlite';
    }

    private function configureServices()
    {
        $app = $this;

        $this['repository.user'] = $this->share(function () use ($app) {
            $repo = new UserRepository($app['db'], $app['repository_container']);
            $repo->setEncoderFactory($app['security.encoder_factory']);

            return $repo;
        });
        $this['repository.programmer'] = $this->share(function () use ($app) {
            return new ProgrammerRepository($app['db'], $app['repository_container']);
        });
        $this['repository.project'] = $this->share(function () use ($app) {
            return new ProjectRepository($app['db'], $app['repository_container']);
        });
        $this['repository.battle'] = $this->share(function () use ($app) {
            return new BattleRepository($app['db'], $app['repository_container']);
        });
        $this['repository.api_token'] = $this->share(function () use ($app) {
            return new ApiTokenRepository($app['db'], $app['repository_container']);
        });
        $this['repository_container'] = $this->share(function () use ($app) {
            return new RepositoryContainer($app, [
                'user' => 'repository.user',
                'programmer' => 'repository.programmer',
                'project' => 'repository.project',
                'battle' => 'repository.battle',
                'api_token' => 'repository.api_token',
            ]);
        });

        $this['battle.battle_manager'] = $this->share(function () use ($app) {
            return new BattleManager(
                $app['repository.battle'],
                $app['repository.programmer']
            );
        });
        $this['battle.power_manager'] = $this->share(function () use ($app) {
            return new PowerManager(
                $app['repository.programmer']
            );
        });

        $this['fixtures_manager'] = $this->share(function () use ($app) {
            return new FixturesManager($app);
        });

        $this['twig.battle_extension'] = $this->share(function () use ($app) {
            return new BattleExtension(
                $app['request_stack'],
                $app['repository.programmer'],
                $app['repository.project']
            );
        });

        $this['annotation_reader'] = $this->share(function () {
            return new AnnotationReader();
        });
        // you could use a cache with annotations if you want
        //$this['annotations.cache'] = new PhpFileCache($this['root_dir'].'/cache');
        //$this['annotation_reader'] = new CachedReader($this['annotations_reader'], $this['annotations.cache'], $this['debug']);

        $this['api.validator'] = $this->share(function () use ($app) {
            return new ApiValidator($app['validator']);
        });
    }

    private function configureSecurity()
    {
        $app = $this;

        $this->register(new SecurityServiceProvider(), [
            'security.firewalls' => [
                'api' => [
                    'pattern' => '^/api',
                    'users' => $this->share(function () use ($app) {
                        return $app['repository.user'];
                    }),
                    'stateless' => true,
                    'anonymous' => true,
                    'api_token' => true,
                ],
                'main' => [
                    'pattern' => '^/',
                    'form' => true,
                    'users' => $this->share(function () use ($app) {
                        return $app['repository.user'];
                    }),
                    'anonymous' => true,
                    'logout' => true,
                ],
            ],
        ]);

        // require login for application management
        $this['security.access_rules'] = [
            // placeholder access control for now
            ['^/register', 'IS_AUTHENTICATED_ANONYMOUSLY'],
            ['^/login', 'IS_AUTHENTICATED_ANONYMOUSLY'],
            // allow anonymous API - if auth is needed, it's handled in the controller
            ['^/api', 'IS_AUTHENTICATED_ANONYMOUSLY'],
            ['^/', 'IS_AUTHENTICATED_FULLY'],
        ];

        // setup our custom API token authentication
        $app['security.authentication_listener.factory.api_token'] = $app->protect(function ($name, $options) use ($app) {
            // the class that reads the token string off of the Authorization header
            $app['security.authentication_listener.'.$name.'.api_token'] = $app->share(function () use ($app) {
                return new ApiTokenListener($app['security'], $app['security.authentication_manager']);
            });

            // the class that looks up the ApiToken object in the database for the given token string
            // and authenticates the user if it's found
            $app['security.authentication_provider.'.$name.'.api_token'] = $app->share(function () use ($app) {
                return new ApiTokenProvider($app['repository.user'], $app['repository.api_token']);
            });

            // the class that decides what should happen if no authentication credentials are passed
            $this['security.entry_point.'.$name.'.api_token'] = $app->share(function () use ($app) {
                return new ApiEntryPoint($app['translator']);
            });

            return [
                // the authentication provider id
                'security.authentication_provider.'.$name.'.api_token',
                // the authentication listener id
                'security.authentication_listener.'.$name.'.api_token',
                // the entry point id
                'security.entry_point.'.$name.'.api_token',
                // the position of the listener in the stack
                'pre_auth',
            ];
        });

        // expose a fake "user" service
        $this['user'] = $this->share(function () use ($app) {
            $user = $app['security']->getToken()->getUser();

            return \is_object($user) ? $user : null;
        });

        $this['serializer'] = $this->share(function () use ($app) {
            $serializer = SerializerBuilder::create()
                ->setCacheDir($app['root_dir'].'/cache/serializer')
                ->setDebug($app['debug'])
                ->setPropertyNamingStrategy(new IdenticalPropertyNamingStrategy());

            return HateoasBuilder::create($serializer)
                ->setUrlGenerator(null, new SymfonyUrlGenerator($app['url_generator']))
                ->build();
        });
    }

    private function configureListeners()
    {
        $app = $this;

        $this->error(function (\Exception $e, $statusCode) use ($app) {
            if (0 !== \strpos($app['request']->getPathInfo(), '/api')) {
                return;
            }

            if ($app['debug'] && 500 == $statusCode) {
                return;
            }

            // only do something special if we have an ApiProblemException!
            $apiProblem = new ApiProblem($statusCode);

            if ($e instanceof ApiProblemException) {
                $apiProblem = $e->getApiProblem();
            }

            if ($e instanceof HttpException) {
                $apiProblem->set('detail', $e->getMessage());
            }

            return ApiProblemResponseFactory::createResponse($apiProblem);
        });
    }
}
