<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return function (ContainerConfigurator $container) {
    $parameters = $container->parameters();
    $services = $container->services();
    $parameters->set('dbConfiguration', []);

    $services->defaults()
        ->private()
        ->autowire()
        ->autoconfigure();

    $services
        ->load('App\\', '../src/*')
        ->exclude('../src/{Content/Entity,Internal}');

};

