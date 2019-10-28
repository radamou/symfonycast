<?php

namespace App\Message\Event;

class ImagePostDeletedEvent
{
    private $fileName;

    public function __construct(string $fileName)
    {
        $this->fileName = $fileName;
    }

    public function getFileName()
    {
        return $this->fileName;
    }
}
