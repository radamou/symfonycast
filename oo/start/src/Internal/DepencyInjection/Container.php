<?php

namespace App\Internal\DependencyInjection;

use App\Content\Battle\ShipLoader;
use App\Internal\Db\Connection;

class Container
{
    public $configuration;
    public $connection;
    public $repository;
    public $shipLoader;

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

    public function getRepository(Connection $connection)
    {
    }

    public function getShipLoader(): ShipLoader
    {
        if(null === $this->shipLoader) {
            $this->shipLoader = new ShipLoader();
        }

        return $this->shipLoader;
    }
}