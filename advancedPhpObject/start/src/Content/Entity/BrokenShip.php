<?php

namespace App\Content\Entity;

class BrokenShip extends AbstractShip
{
    public function getJediFactor(): int
    {
        return 0;
    }

    public function isFunctional(): bool
    {
        return false;
    }

    public function getType(): string
    {
        return 'broken';
    }
}
