<?php

namespace App\Content\Battle;

use App\Content\Collection\ShipCollection;
use App\Content\Entity\AbstractShip;

class LoggableShipLoader implements ShipLoaderInterface
{
    private $shipLoader;

    public function __construct(ShipLoaderInterface $shipLoader)
    {
        $this->shipLoader = $shipLoader;
    }

    public function fetchAll(): ShipCollection
    {
        return $this->shipLoader->fetchAll();
    }

    public function fetchOne(int $shipId): AbstractShip
    {
        return $this->shipLoader->fetchOne($shipId);
    }
}