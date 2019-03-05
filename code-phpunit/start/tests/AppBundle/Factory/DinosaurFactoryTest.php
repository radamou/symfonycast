<?php

namespace Tests\AppBundle\Factory;

use AppBundle\Entity\Dinosaur;
use AppBundle\Factory\DinosaurFactory;
use AppBundle\Service\DinosaurLengthDeterminator;
use PHPUnit\Framework\TestCase;

class DinosaurFactoryTest extends TestCase
{
    /**
     * @var DinosaurFactory
     */
    private $dinosaurFactory;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $lengthDeterminator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->lengthDeterminator = $this->createMock(DinosaurLengthDeterminator::class);
        $this->dinosaurFactory = new DinosaurFactory($this->lengthDeterminator);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->dinosaurFactory = null;
    }

    public function testItGrowsALargeVelociraptor()
    {
        $dinosaur = $this->dinosaurFactory->growVelociraptor(5);

        $this->assertInstanceOf(Dinosaur::class, $dinosaur);
        $this->assertSame('Velociraptor', $dinosaur->getGenus());
        $this->assertSame(5, $dinosaur->getLength());
    }

    public function estItGrowsATriceraptors()
    {
        $this->markTestIncomplete('waiting for the details for this case');
    }

    public function testItGrowsABabyVelociraptor()
    {
        if (!class_exists('Nanny')) {
            $this->markTestSkipped('There is nobody to watch the baby!');
        }

        $dinosaur = $this->dinosaurFactory->growVelociraptor(1);
        $this->assertSame(1, $dinosaur->getLength());
    }

    /**
     * @dataProvider  getSpecificationTests
     */
    public function testItGrowsADinosaurFromSpecification(
        string $spec,
        bool $expectedIsCarnivorous
    )
    {
        $this->lengthDeterminator
            ->expects($this->once())
            ->method('getLengthFromSpecification')
            ->with($spec)
            ->willReturn(20);
        $dinosaur =$this->dinosaurFactory->growFromSpecification($spec);
        $this->assertSame(20, $dinosaur->getLength());
        $this->assertSame($expectedIsCarnivorous, $dinosaur->isCarnivorous(), 'Diets do not match');
    }

    public function getSpecificationTests()
    {
        return [
            // specification, is carnivorous
            ['large carnivorous dinosaur', true],
            ['large herbivore', false],
        ];
    }
}