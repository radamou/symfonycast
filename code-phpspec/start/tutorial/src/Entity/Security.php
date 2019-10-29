<?php

namespace App\Entity;

class Security
{
    private $name;

    private $isActive;

    private $enclosure;

    public function __construct(string $name, bool $isActive, Enclosure $enclosure)
    {
        $this->name = $name;
        $this->isActive = $isActive;
        $this->enclosure = $enclosure;
    }

    public function getIsActive(): bool
    {
        return $this->isActive;
    }
}
