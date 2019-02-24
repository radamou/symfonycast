<?php

namespace App\Content\Entity;

class BountyHunterShip extends AbstractShip
{
    use SettableJediFactorTrait;

    public function isFunctional(): bool
    {
        return true;
    }

    public function getType(): string
    {
        return "bounty hunter";
    }
}
