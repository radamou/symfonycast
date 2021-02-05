<?php

use App\Presentation\Battle\Index as Battle;
use App\Presentation\Home\Index as Home;

require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

try {
    $routeCollection = new RouteCollection();
    $routeCollection->add('battle', new Route(
        '/battle',
        ['_controller' => Battle::class, 'method' => 'GET']
    ));
    $routeCollection->add('home', new Route(
        '/home',
        ['_controller' => Home::class, 'method' => 'GET']
    ));

   return $routeCollection;

} catch (ResourceNotFoundException $e) {
    throw  new ResourceNotFoundException($e->getMessage());
}

