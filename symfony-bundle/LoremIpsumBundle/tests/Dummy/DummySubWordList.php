<?php

namespace KnpU\LoremIpsumBundle\Tests\Dummy;

use KnpU\LoremIpsumBundle\Provider\KnpUWordProviderInterface;

class DummySubWordList implements KnpUWordProviderInterface
{
    public function getWordList(): array
    {
        return ['stub1', 'stub2'];
    }

}