<?php

namespace  App\Content\Repository;

use App\Content\Entity\AbstractShip;
use App\Content\Entity\Ship;
use App\Content\Entity\BrokenShip;

class ShipRepository extends AbstractRepository
{
    /**
     * @return AbstractShip[]
     */
    public function fetchAllData()
    {
        return [
            'starfighter' => new Ship('Jedi Starfighter'),
            'cloakshape_fighter' => new Ship('cloakshape fighter'),
            'super_star_destroyer' => new Ship('super star destroyer'),
            'rz1_a_wing_interceptor' => new Ship('rz1 a wing interceptor'),
            'broken ship' => new BrokenShip('Just a hunk of metal')
        ];
    }

    public function fetchSingleData(int $id): Ship
    {
        $pdo = $this->connection->getPdo();
        $pdo->prepare('SELECT * FROM ship WHERE id = :id');
    }
}