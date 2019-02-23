<?php

namespace  App\Entity;

class Ship extends AbstractShip
{
    public function getJediFactor(): int
    {
        return 900;
    }

    public function isFunctional()
    {
        return !mt_rand(1, 100) < 30;
    }

    public function getType(): string
    {
        return 'Empire';
    }
}
