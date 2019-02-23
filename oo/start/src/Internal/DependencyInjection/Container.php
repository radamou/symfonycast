<?php

namespace App\Internal\DependencyInjection;

use App\Content\Battle\ShipLoader;
use App\Content\FixtureLoader\JsonFileLoadFixtures;
use App\Internal\Storage\Connection;
use App\Internal\Storage\LoaderInterface;
use App\Repository\AbstractRepository;

class Container
{
    public $configuration;
    public $connection;
    public $repository;
    public $shipLoader;
    public $jsonFixtureLoader;

    public function __construct(array $configuration)
    {
       $this->configuration = $configuration;
    }

    public function getConnection(): Connection
    {
        if(null === $this->connection) {
            $this->connection =  new Connection($this->configuration['db']);
        }

        return $this->connection;
    }

    public function getRepository(Connection $connection): AbstractRepository
    {
    }

    public function getJsonFixtureLoader(): LoaderInterface
    {
        if ($this->jsonFixtureLoader === null) {
            $this->jsonFixtureLoader = new JsonFileLoadFixtures(
                __DIR__.'/../../../config/Fixtures/ships.json'
            );
        }

        return $this->jsonFixtureLoader;
    }

    public function getShipLoader(): ShipLoader
    {
        if(null === $this->shipLoader) {
            $this->shipLoader = new ShipLoader($this->getJsonFixtureLoader());
        }

        return $this->shipLoader;
    }
}