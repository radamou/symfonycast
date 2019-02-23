<?php


namespace App\Content\Entity;

abstract class AbstractShip
{
    private $id;
    private $name;
    private $weaponPower = 0;
    private $strength = 0;
    private $jediFactor = 0;

    abstract public function getJediFactor();
    abstract public function isFunctional();
    abstract public function getType();

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string  $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getWeaponPower(): int
    {
        return $this->weaponPower;
    }

    public function setWeaponPower(int $weaponPower): self
    {
        $this->weaponPower = $weaponPower;

        return $this;
    }

    public function getStrength()
    {
        return $this->strength;
    }

    public function setStrength(int $number): self
    {
        $this->strength = $number;

        return $this;
    }

    public function setJediFactor(int $jediFactor): self
    {
        $this->jediFactor = $jediFactor;

        return $this;
    }

    public function doesGivenShipHaveMoreStrength($givenShip): bool
    {
        return $givenShip->strength > $this->strength;
    }

    public function getNameAndSpecs(bool $useShortFormat = false): string
    {
        if ($useShortFormat) {
            return sprintf(
                '%s: %s/%s/%s',
                $this->name,
                $this->weaponPower,
                $this->getJediFactor(),
                $this->strength
            );
        }

        return sprintf(
            '%s: w:%s, j:%s, s:%s',
            $this->name,
            $this->weaponPower,
            $this->getJediFactor(),
            $this->strength
        );
    }
}