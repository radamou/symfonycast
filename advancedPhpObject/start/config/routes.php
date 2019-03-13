<?php

require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

try {
    $routeCollection = new RouteCollection();
    $routeCollection->add('battle', new Route(
        '/home',
        ['_controller' => '\App\Controller\StarShipAction::indexAction', 'method' => 'GET']
    ));

   return $routeCollection;

}catch (ResourceNotFoundException $e) {
    throw  new ResourceNotFoundException($e->getMessage());
}


//This example is for loading routes with annotation
// (it is not finished, I need to install doctrine cache and doctrine annotation)

/*use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
return function (RoutingConfigurator $routes) {
    $routes->import(__DIR__.'/../src/Controller', 'annotation');
};*/