<?php

namespace App\Content\Battle;

use App\Entity\AbstractShip;
use App\Internal\Storage\LoaderInterface;

class ShipLoader
{
    private $jsonFixturesLoader;

    public function __construct(LoaderInterface $jsonFixturesLoader)
    {
        $this->jsonFixturesLoader = $jsonFixturesLoader;
    }

    /**
     * @return  AbstractShip[]
     */
    public function load() {

        return $this->jsonFixturesLoader->fetchAllData();
    }

    public function loadOne(int $shipId): AbstractShip
    {

        return $this->jsonFixturesLoader->fetchSingleData($shipId);
    }
}