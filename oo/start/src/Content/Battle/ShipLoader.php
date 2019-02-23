<?php

namespace App\Content\Battle;

use App\Content\Entity\AbstractShip;
use App\Content\Entity\BrokenShip;
use App\Content\Entity\RebelShip;
use App\Content\Entity\Ship;
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

        $result = $this->jsonFixturesLoader->fetchAllData();
        $ships = [];

        foreach ($result as $ship) {
            $ships[] = $this->createFromData($ship);
        }

        return $ships;
    }

    public function loadOne(int $shipId): AbstractShip
    {
        $ship =  $this->jsonFixturesLoader->fetchSingleData($shipId);

        return $this->createFromData($ship);
    }

    public function createFromData(array $data): ?AbstractShip
    {

        if (!isset($data['team'])){
            return null;
        }

        $ship = new Ship();

        if('rebel' === $data['team']) {
            $ship = new RebelShip();
        }

        if('broken' === $data['team']) {
            $ship = new BrokenShip();
        }

        return $ship->setId($data['id'])
            ->setName($data['name'])
            ->setWeaponPower($data['weapon_power'])
            ->setJediFactor($data['jedi_factor'])
            ->setStrength($data['strength']);
    }
}