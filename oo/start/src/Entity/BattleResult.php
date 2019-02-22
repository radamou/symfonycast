<?php

namespace App\Entity;

class BattleResult
{
    private $winningShip;
    private $losingShip;
    private $useJediPowers;

    public function __construct(
        Ship $winningShip,
        Ship $losingShip,
        bool $useJediPowers
    )
    {
        $this->winningShip = $winningShip;
        $this->losingShip = $losingShip;
        $this->useJediPowers = $useJediPowers;
    }

    public function getWinningShip(): Ship
    {
        return $this->winningShip;
    }

    public function setWinningShip(?Ship $winningShip): self
    {
        $this->winningShip = $winningShip;

        return $this;
    }

    public function getLosingShip(): Ship
    {
        return $this->losingShip;
    }

    public function setLosingShip(?Ship $losingShip): self
    {
        $this->losingShip = $losingShip;

        return $this;
    }

    public function getUseJediPowers(): bool
    {
        return $this->useJediPowers;
    }

    public function setUseJediPowers(bool $useJediPowers): self
    {
        $this->useJediPowers = $useJediPowers;

        return $this;
    }

    public function isThereAWinner(): bool
    {
        return null !== $this->winningShip;
    }

    public function isThereALoser(): bool
    {
        return null !== $this->losingShip;
    }
}