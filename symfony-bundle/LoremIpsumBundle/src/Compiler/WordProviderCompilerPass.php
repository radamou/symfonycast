<?php

namespace  KnpU\LoremIpsumBundle\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class WordProviderCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $definition = $container->getDefinition('knpu_lorem_ipsum.knpu_ipsum');
        $references = [];

        foreach ($container->findTaggedServiceIds('knpu_ipsum_word_provider') as $id => $tag) {
            $references[] =  new Reference($id);
        }

        $definition->setArgument(0, $references);
    }
}