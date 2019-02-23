<?php

namespace App\Entity;

class BattleResult
{
    private $winningShip;
    private $losingShip;
    private $useJediPowers;

    public function __construct(
        AbstractShip $winningShip,
        AbstractShip $losingShip,
        bool $useJediPowers
    )
    {
        $this->winningShip = $winningShip;
        $this->losingShip = $losingShip;
        $this->useJediPowers = $useJediPowers;
    }

    public function getWinningShip(): AbstractShip
    {
        return $this->winningShip;
    }

    public function setWinningShip(?AbstractShip $winningShip): self
    {
        $this->winningShip = $winningShip;

        return $this;
    }

    public function getLosingShip(): AbstractShip
    {
        return $this->losingShip;
    }

    public function setLosingShip(?AbstractShip $losingShip): self
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