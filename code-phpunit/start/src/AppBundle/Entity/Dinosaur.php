<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="dinosaurs")
 */
class Dinosaur
{
    const LARGE = 20;
    const HUGE = 30;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $length = 0;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $genus;
    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $isCarnivorous;

    /**
     * @var Enclosure
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Enclosure", inversedBy="dinosaurs")
     */
    private $enclosure;

    public function setEnclosure(Enclosure $enclosure)
    {
        $this->enclosure = $enclosure;
    }

    public function __construct(string $genus = 'Unknown', bool $isCarnivorous = false)
    {
        $this->genus = $genus;
        $this->isCarnivorous = $isCarnivorous;
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

    public function getGenus(): string
    {
        return $this->genus;
    }


    public function setGenus(string $genus): self
    {
        $this->genus = $genus;

        return $this;
    }

    public function isCarnivorous(): bool
    {
        return $this->isCarnivorous;
    }

    public function getSpecification(): string
    {
        return sprintf(
            'The %s %scarnivorous dinosaur is %s meters long',
            $this->genus,
            $this->isCarnivorous? '' : 'non-',
            $this->length
        );
    }
}
