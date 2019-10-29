<?php

namespace spec\App\Entity;

use App\Entity\Dinosaur;
use PhpSpec\Exception\Example\FailureException;
use PhpSpec\ObjectBehavior;

class DinosaurSpec extends ObjectBehavior
{
    public function getMatchers(): array
    {
        return [
            'returnZero' => function (int $subject) {
                if ($subject !== 0) {
                    throw new FailureException(sprintf(
                        'Returned value should be zero, got "%s"',
                        $subject
                    ));
                }

                return true;
            },
        ];
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Dinosaur::class);
    }

    function it_should_default_to_zero_length()
    {
        $this->getLength()->shouldReturn(0);
    }

    function it_should_allow_to_set_length()
    {
        $this->setLength(9);
        $this->getLength()->shouldReturn(9);
    }

    function it_should_default_to_zero_length_using_custom_matcher()
    {
        $this->getLength()->shouldReturnZero(12);
    }

    function it_should_not_shrink()
    {
        $this->setLength(15);

        $this->getLength()->shouldBeGreaterThan(12);
    }

    function it_should_return_full_description()
    {
        $this->getDescription()->shouldReturn('The Unknown non-carnivorous dinosaur is 0 meters long');
    }

    function it_should_return_full_description_for_tyrannosaurus()
    {
        $this->beConstructedWith('Tyrannosaurus', true);
        $this->setLength(12);
        $this->getDescription()->shouldReturn('The Tyrannosaurus carnivorous dinosaur is 12 meters long');
    }

    function it_should_grow_a_large_velociraptor()
    {
        $this->beConstructedThrough('growVelociraptor', [5]);
        $this->getType()->shouldBeString();
        $this->getType()->shouldBe('Velociraptor');
    }
}
