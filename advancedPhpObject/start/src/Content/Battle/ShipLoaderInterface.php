<?php

namespace App\Content\Battle;

use App\Content\Collection\ShipCollection;
use App\Content\Entity\AbstractShip;

interface ShipLoaderInterface
{
    public function fetchAll(): ShipCollection;
    public function fetchOne(int $shipId): ?AbstractShip;
}
