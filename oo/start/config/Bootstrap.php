<?php

require_once(__DIR__.'/../src/Internal/DependencyInjection/Container.php');
require_once __DIR__.'/../src/Internal/Storage/LoaderInterface.php';
require_once __DIR__.'/../src/Content/Entity/AbstractShip.php';
require_once __DIR__.'/../src/Content/Entity/Ship.php';
require_once __DIR__.'/../src/Content/Entity/RebelShip.php';
require_once __DIR__.'/../src/Content/Entity/BrokenShip.php';
require_once __DIR__.'/../src/Content/Entity/BattleResult.php';
require_once __DIR__.'/../src/Content/FixtureLoader/JsonFileLoadFixtures.php';
require_once __DIR__.'/../src/Content/Battle/BattleManager.php';
require_once __DIR__.'/../src/Content/Battle/ShipLoader.php';


$dbConfiguration = [
    'dbDns' => 'mysql:host=localhost;dbname=',
    'dbName' => 'battleShip',
    'dbUser' => 'radamou',
    'dbPassword' => 'radamou',
];