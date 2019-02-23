<?php

spl_autoload_register(function($className) {
    $className = str_replace('App\\', '', $className);
    $path = __DIR__.'/../src/'.str_replace('\\', '/', $className).'.php';

    if (file_exists($path)) {
        require_once $path;
    }
});

$dbConfiguration = [
    'dbDns' => 'mysql:host=localhost;dbname=',
    'dbName' => 'battleShip',
    'dbUser' => 'radamou',
    'dbPassword' => 'radamou',
];