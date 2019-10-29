<?php

namespace App\Service;

interface EntityManagerInterface
{
    public function persist($object);

    public function flush();
}
