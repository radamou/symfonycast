<?php


namespace Tests\AppBundle\Service;

use AppBundle\Entity\Dinosaur;
use AppBundle\Entity\Enclosure;
use AppBundle\Factory\DinosaurFactory;
use AppBundle\Service\EnclosureBuilderService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

class EnclosureBuilderServiceTest extends TestCase
{
    public function testItBuildsAndPersistsEnclosure()
    {
        /*$em = $this->createMock(EntityManagerInterface::class);
        $dinoFactory = $this->createMock(DinosaurFactory::class);

        $em->expects($this->once())
            ->method('persist')
            ->with($this->isInstanceOf(Enclosure::class));

        $em->expects($this->atLeastOnce())
            ->method('flush');

        $dinoFactory->expects($this->exactly(2))
            ->method('growFromSpecification')
            ->with($this->isType('string'))
            ->willReturn(new Dinosaur());*/

        $em = $this->prophesize(EntityManagerInterface::class);
        $em->persist(Argument::type(Enclosure::class))
            ->shouldBeCalledTimes(1);
        $em->flush()->shouldBeCalled();

        $dinoFactory = $this->prophesize(DinosaurFactory::class);
        $dinoFactory
            ->growFromSpecification(Argument::type('string'));

        $dinoFactory
            ->growFromSpecification(Argument::type('string'))
            ->shouldBeCalledTimes(2)
            ->willReturn(new Dinosaur());

        $builder = new EnclosureBuilderService($em->reveal(), $dinoFactory->reveal());
        $enclosure = $builder->buildEnclosure(1, 2);

        $this->assertCount(1, $enclosure->getSecurities());
        $this->assertCount(2, $enclosure->getDinosaurs());
    }
}