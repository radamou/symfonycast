<?php

namespace  KnpU\LoremIpsumBundle\DependencyInjection;

use KnpU\LoremIpsumBundle\Provider\KnpUWordProviderInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;


class KnpULoremIpsumExtension extends Extension
{

    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config/'));

        try {
            $loader->load('services.xml');

            $configuration = $this->getConfiguration($configs, $container);
            $config = $this->processConfiguration($configuration, $configs);
            $definition = $container->getDefinition('knpu_lorem_ipsum.knpu_ipsum');
            $definition->setArgument(1, $config['unicorns_are_real']);
            $definition->setArgument(2, $config['min_sunshine']);

            $container->registerForAutoconfiguration(KnpUWordProviderInterface::class)
                ->addTag('knpu_ipsum_word_provider');

        }catch (\InvalidArgumentException $exception) {
            throw new \InvalidArgumentException($exception->getMessage());
        }
    }

    public function getAlias()
    {
        return 'knpu_lorem_ipsum';
    }
}