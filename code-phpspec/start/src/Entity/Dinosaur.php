<?php

namespace App\Entity;

class Dinosaur
{
    private $length = 0;
    private $type;
    private $isCarnivorous;

    public function __construct(string  $type = 'Unknown', bool $isCarnivorous = false)
    {
        $this->type = $type;
        $this->isCarnivorous = $isCarnivorous;
    }

    public static function growVelociraptor(int $length): self
    {
        $dinosaur = new static('Velociraptor', true);
        $dinosaur->setLength($length);

        return $dinosaur;
    }

    public function getLength(): int
    {
        return $this->length;
    }

    public function setLength(int $length): self
    {
        $this->length = $length;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function isCarnivorous(): bool
    {
        return $this->isCarnivorous;
    }

    public function setIsCarnivorous(bool $isCarnivorous): void
    {
        $this->isCarnivorous = $isCarnivorous;
    }

    public function getDescription(): string
    {
        return sprintf(
            'The %s %scarnivorous dinosaur is %d meters long',
            $this->type,
            $this->isCarnivorous ? '' : 'non-',
            $this->length
        );
    }
}
