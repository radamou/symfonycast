<?php

namespace App\Service;

use KnpU\LoremIpsumBundle\Provider\KnpUWordProviderInterface;

class CustomWordProvider implements KnpUWordProviderInterface
{
    public function getWordList(): array
    {
        return ['beach'];
    }
}