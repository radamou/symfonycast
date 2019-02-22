<?php

namespace  App\Repository;

use App\Entity\Ship;

class ShipRepository extends AbstractRepository
{
    /**
     * @return Ship[]
     */
    public function findAll()
    {
        return [
            'starfighter' => new Ship('Jedi Starfighter', 5, 15,30),
            'cloakshape_fighter' => new Ship('cloakshape fighter', 70, 0, 500),
            'super_star_destroyer' => new Ship('super star destroyer', 70, 0, 500),
            'rz1_a_wing_interceptor' => new Ship('rz1 a wing interceptor', 4, 4, 50)
        ];
    }

    public function findOne(int $id): Ship
    {
        $pdo = $this->connection->getPdo();
        $pdo->prepare('SELECT * FROM ship WHERE id = :id');
    }
}