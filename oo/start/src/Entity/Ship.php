<?php

namespace  App\Entity;

class Ship
{
    private $id;
    private $name;
    private $weaponPower = 0;
    private $jediFactor = 0;
    private $strength = 0;
    private $underRepair;

    public function __construct(
        string $name,
        int $weaponPower,
        int $strength,
        int $jediFactor
    )
    {
        $this->name = $name;
        $this->weaponPower = $weaponPower;
        $this->strength = $strength;
        $this->jediFactor = $jediFactor;
        $this->underRepair = mt_rand(1, 100) < 30;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function isFunctional(): bool
    {
        return !$this->underRepair;
    }

    public function sayHello(): void
    {
        echo 'Hello!';
    }

    public function getName(): string
    {
        return $this->name;
    }
    
    public function setStrength(int $number): self
    {
        $this->strength = $number;

        return $this;
    }

    public function getStrength()
    {
        return $this->strength;
    }

    public function getNameAndSpecs(bool $useShortFormat = false): string
    {
        if ($useShortFormat) {
            return sprintf(
                '%s: %s/%s/%s',
                $this->name,
                $this->weaponPower,
                $this->jediFactor,
                $this->strength
            );
        } else {
            return sprintf(
                '%s: w:%s, j:%s, s:%s',
                $this->name,
                $this->weaponPower,
                $this->jediFactor,
                $this->strength
            );
        }
    }

    public function doesGivenShipHaveMoreStrength($givenShip): bool
    {
        return $givenShip->strength > $this->strength;
    }

    public function getWeaponPower(): int
    {
        return $this->weaponPower;
    }

    public function getJediFactor(): int
    {
        return $this->jediFactor;
    }

    public function setName(string  $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function setWeaponPower(int $weaponPower): self
    {
        $this->weaponPower = $weaponPower;

        return $this;
    }

    public function setJediFactor(int $jediFactor): self
    {
        $this->jediFactor = $jediFactor;

        return $this;
    }
}
