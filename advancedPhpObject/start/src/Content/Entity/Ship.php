<?php

namespace  App\Content\Entity;

class Ship extends AbstractShip
{
    use SettableJediFactorTrait;

    public function isFunctional(): bool
    {
        return !mt_rand(1, 100) < 30;
    }

    public function getType(): string
    {
        return 'Empire';
    }
}
