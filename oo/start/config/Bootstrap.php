<?php

require_once __DIR__.'/../vendor/autoload.php';

use App\Internal\DependencyInjection\Container;
$container = new Container([]);

$dbConfiguration = [
    'dbDns' => 'mysql:host=localhost;dbname=',
    'dbName' => 'battleShip',
    'dbUser' => 'radamou',
    'dbPassword' => 'radamou',
];