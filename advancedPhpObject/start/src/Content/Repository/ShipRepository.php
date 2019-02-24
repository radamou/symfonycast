<?php

namespace  App\Content\Repository;

use App\Content\Entity\Ship;
use App\Content\Entity\BrokenShip;

class ShipRepository extends AbstractRepository
{
    public function fetchAllData(): array
    {
        return [
            'starfighter' => (new Ship())->setName('Jedi Starfighter'),
            'cloakshape_fighter' => (new Ship())->setName('cloakshape fighter'),
            'super_star_destroyer' => (new Ship())->setName('super star destroyer'),
            'rz1_a_wing_interceptor' => (new Ship())->setName('rz1 a wing interceptor'),
            'broken ship' => (new BrokenShip())->setName('Just a hunk of metal')
        ];
    }

    public function fetchSingleData(int $id): array
    {
        $pdo = $this->connection->getPdo();
        $pdo->prepare('SELECT * FROM ship WHERE id = :id');
    }
}
