<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Internal\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use App\Kernel;

$container = new Container([]);

$request = Request::createFromGlobals();
$routes = include __DIR__ . '/config/routes.php';

$context = new RequestContext();
$matcher = new UrlMatcher($routes, $context);
$controllerResolver = new ControllerResolver();
$argumentResolver = new ArgumentResolver();

$framework = new Kernel($matcher, $controllerResolver, $argumentResolver);
$response = $framework->handle($request);

$response->send();