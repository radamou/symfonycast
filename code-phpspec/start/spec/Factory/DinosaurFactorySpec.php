<?php

namespace spec\App\Factory;

use App\Factory\DinosaurFactory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DinosaurFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(DinosaurFactory::class);
    }
}
