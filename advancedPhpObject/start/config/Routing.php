<?php

require_once '../vendor/autoload.php';

use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

try {
    $starShipRoute = new Route(
        '/starShip',
        ['controller' => \App\Controller\StarShipAction::class, 'method' => 'indexAction']
    );

    $routeCollection = new RouteCollection();
    $routeCollection->add('star_ship_route', $starShipRoute);

    $context = new RequestContext();
    $context->fromRequest(Request::createFromGlobals());

    $matcher = new UrlMatcher($routeCollection, $context);
    $parameter = $matcher->match($context->getPathInfo());

    $generator = new UrlGenerator($routeCollection, $context);

}catch (ResourceNotFoundException $e) {
    throw  new ResourceNotFoundException();
}