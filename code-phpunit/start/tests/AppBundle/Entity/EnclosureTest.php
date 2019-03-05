<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Dinosaur;
use AppBundle\Exception\DinosaursAreRunningRampantException;
use AppBundle\Exception\NotABuffetException;
use PHPUnit\Framework\TestCase;
use AppBundle\Entity\Enclosure;

class EnclosureTest extends  TestCase
{
    /**
     * @var Enclosure
     */
    private $enclosure;

    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->enclosure = null;
    }

    public function testItHasNoDinosaursByDefault()
    {
        $this->enclosure = new Enclosure();
        $this->assertEmpty($this->enclosure->getDinosaurs());
    }

    public function testItAddsDinosaurs()
    {
        $this->enclosure = new Enclosure(true);
        $this->enclosure->addDinosaur(new Dinosaur());
        $this->enclosure->addDinosaur(new Dinosaur());
        $this->assertCount(2, $this->enclosure->getDinosaurs());
    }

    /**
     * @expectedException \AppBundle\Exception\NotABuffetException
     */
    public function testItDoesNotAllowToAddNonCarnivorousDinosaursToCarnivorousEnclosure()
    {
        $enclosure = new Enclosure(true);
        $enclosure->addDinosaur(new Dinosaur('Velociraptor', true));
        $enclosure->addDinosaur(new Dinosaur());
    }

    public function testItDoesNotAllowToAddDinosToUnsecureEnclosures()
    {
        $enclosure = new Enclosure();
        $this->expectException(DinosaursAreRunningRampantException::class);
        $this->expectExceptionMessage('Are you craaazy?!?');
        $enclosure->addDinosaur(new Dinosaur());
    }
}