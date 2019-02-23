<?php

namespace App\Content\Entity;

class RebelShip extends AbstractShip
{
    public function getFavoriteJedi(): string
    {
        $coolJedis = ['Yoda', 'Ben Kenobi'];
        $key = array_rand($coolJedis);

        return $coolJedis[$key];
    }

    public function getType(): string
    {
        return 'rebel';
    }

    public function isFunctional(): bool
    {
        return true;
    }

    public function getJediFactor(): int
    {
        return 500;
    }
}