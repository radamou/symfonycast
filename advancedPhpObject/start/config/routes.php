<?php

require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

/*use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;*/

return function (RoutingConfigurator $routes) {
    $routes->import(__DIR__.'/../src/Controller', 'annotation');
};


/*try {
    $routeCollection = new RouteCollection();
    $routeCollection->add('battle', new Route(
        '/home',
        ['_controller' => '\App\Controller\StarShipAction::indexAction', 'method' => 'GET']
    ));

   return $routeCollection;

}catch (ResourceNotFoundException $e) {
    throw  new ResourceNotFoundException($e->getMessage());
}*/