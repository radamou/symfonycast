<?php

namespace App\Content\Entity;

trait SettableJediFactorTrait
{
    private $jediFactor;

    public function getJediFactor(): ?int
    {
        return $this->jediFactor;
    }

    public function setJediFactor(int $jediFactor): self
    {
        $this->jediFactor = $jediFactor;

        return $this;
    }
}
