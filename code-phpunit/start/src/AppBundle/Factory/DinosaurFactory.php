<?php

namespace AppBundle\Factory;

use AppBundle\Entity\Dinosaur;
use AppBundle\Service\DinosaurLengthDeterminator;

class DinosaurFactory
{
    private $dinosaurLengthDeterminator;

    public function __construct(DinosaurLengthDeterminator $dinosaurLengthDeterminator)
    {
        $this->dinosaurLengthDeterminator = $dinosaurLengthDeterminator;

    }

    public function growVelociraptor(int $length): Dinosaur
    {
        return $this->createDinosaur('Velociraptor', true, $length);
    }

    public function growFromSpecification(string $specification): Dinosaur
    {
        $codeName = 'InG-' . \random_int(1, 99999);
        $length = $this->dinosaurLengthDeterminator->getLengthFromSpecification($specification);
        $isCarnivorous = false;

        if (stripos($specification, 'carnivorous') !== false) {
            $isCarnivorous = true;
        }

        $dinosaur = $this->createDinosaur($codeName, $isCarnivorous, $length);

        return $dinosaur;
    }


    private function createDinosaur(string $genus, bool $isCarnivorous, int $length): Dinosaur
    {
        return (new Dinosaur($genus, $isCarnivorous))->setLength($length);
    }
}