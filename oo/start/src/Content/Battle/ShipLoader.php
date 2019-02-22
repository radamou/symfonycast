<?php

namespace App\Content\Battle;

use App\Entity\Ship;
use App\Repository\ShipRepository;

class ShipLoader
{
    /**
     * @return  Ship[]
     */
    public function load() {
        $shipRepository = new ShipRepository();

        return $shipRepository->findAll();
    }

    public function loadOne(int $shipId) {
        $shipRepository = new ShipRepository();

        return $shipRepository->findOne($shipId);
    }
}