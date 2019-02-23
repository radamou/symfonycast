<?php

namespace App\Content\Entity;

class BrokenShip extends  AbstractShip
{

    public function getJediFactor()
    {
        return 0;
    }

    public function isFunctional()
    {
        return false;
    }

    public function getType()
    {
        return 'broken';
    }
}