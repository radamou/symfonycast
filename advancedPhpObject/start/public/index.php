<?php

use Symfony\Component\HttpFoundation\Request;
use App\Kernel;

require_once __DIR__ . '/../vendor/autoload.php';
require_once  __DIR__.'/../config/services.php';

$request = Request::createFromGlobals();
$routes = include __DIR__ . '/../config/routes.php';

$framework = new Kernel($routes);
$response = $framework->handle($request);

$response->send();