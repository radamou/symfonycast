<?php

namespace KnpU\Application\Controller;

use JMS\Serializer\SerializationContext;
use KnpU\Application\Application;
use KnpU\CodeBattle\Battle\BattleManager;
use KnpU\CodeBattle\Model\Programmer;
use KnpU\CodeBattle\Model\User;
use KnpU\CodeBattle\Repository\BattleRepository;
use KnpU\CodeBattle\Repository\ProgrammerRepository;
use KnpU\CodeBattle\Repository\ProjectRepository;
use KnpU\CodeBattle\Repository\UserRepository;
use KnpU\CodeBattle\Security\Token\ApiTokenRepository;
use Silex\Application as SilexApplication;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Base controller class to hide Silex-related implementation details.
 */
abstract class BaseController implements ControllerProviderInterface
{
    /** @var Application */
    protected $container;

    public function __construct(Application $app)
    {
        $this->container = $app;
    }

    abstract protected function addRoutes(ControllerCollection $controllers);

    public function connect(SilexApplication $app)
    {
        $controllers = $app['controllers_factory'];

        $this->addRoutes($controllers);

        return $controllers;
    }


    public function render(string $template, array $variables = []): string
    {
        return $this->container['twig']->render($template, $variables);
    }


    public function isUserLoggedIn(): bool
    {
        return $this->container['security']->isGranted('IS_AUTHENTICATED_FULLY');
    }

    /**
     * @return User|null
     */
    public function getLoggedInUser()
    {
        if (!$this->isUserLoggedIn()) {
            return;
        }

        return $this->container['security']->getToken()->getUser();
    }

    public function generateUrl(string $routeName, array $parameters = [], bool $absolute = false): string
    {
        return $this->container['url_generator']->generate(
            $routeName,
            $parameters,
            $absolute
        );
    }

    public function redirect(string $url, int $status = 302): RedirectResponse
    {
        return new RedirectResponse($url, $status);
    }


    public function loginUser(User $user): void
    {
        $token = new UsernamePasswordToken($user, $user->getPassword(), 'main', $user->getRoles());

        $this->container['security']->setToken($token);
    }

    public function setFlash(string $message, bool $positiveNotice = true): void
    {
        /** @var Request $request */
        $request = $this->container['request_stack']->getCurrentRequest();
        $noticeKey = $positiveNotice ? 'notice_happy' : 'notice_sad';

        $request->getSession()->getFlashbag()->add($noticeKey, $message);
    }


    public function findUserByUsername(string $username): User
    {
        return $this->getUserRepository()->findUserByUsername($username);
    }

    public function save(object $obj)
    {
        switch (true) {
            case $obj instanceof Programmer:
                $this->getProgrammerRepository()->save($obj);
                break;
            default:
                throw new \Exception(\sprintf('Shortcut for saving "%s" not implemented', \get_class($obj)));
        }
    }


    public function delete(object $obj)
    {
        switch (true) {
            case $obj instanceof Programmer:
                $this->getProgrammerRepository()->delete($obj);
                break;
            default:
                throw new \Exception(\sprintf('Shortcut for saving "%s" not implemented', \get_class($obj)));
        }
    }

    public function throw404(string $message = 'Page not found')
    {
        throw new NotFoundHttpException($message);
    }

    public function validate(object $obj)
    {
        return $this->container['api.validator']->validate($obj);
    }

    protected function getUserRepository(): UserRepository
    {
        return $this->container['repository.user'];
    }

    protected function getProgrammerRepository(): ProgrammerRepository
    {
        return $this->container['repository.programmer'];
    }

    protected function getProjectRepository(): ProjectRepository
    {
        return $this->container['repository.project'];
    }

    protected function getBattleRepository(): BattleRepository
    {
        return $this->container['repository.battle'];
    }

    protected function getBattleManager(): BattleManager
    {
        return $this->container['battle.battle_manager'];
    }

    protected function getApiTokenRepository(): ApiTokenRepository
    {
        return $this->container['repository.api_token'];
    }

    protected function createApiResponse($data, int $statusCode = 200): Response
    {
        $json = $this->serialize($data);

        return new Response($json, $statusCode,
            [
                'Content-Type' => 'application/json',
            ]
        );
    }

    protected function serialize($data): string
    {
        $context = (new SerializationContext())->setSerializeNull(true);

        return $this->container['serializer']->serialize($data, 'json', $context);
    }

    protected function enforceProgrammerOwnershipSecurity(Programmer $programmer)
    {
        $this->enforceUserSecurity();

        if ($this->getLoggedInUser()->id != $programmer->userId) {
            throw new AccessDeniedException();
        }
    }

    protected function enforceUserSecurity()
    {
        if (!$this->isUserLoggedIn()) {
            throw new AccessDeniedException();
        }
    }
}
