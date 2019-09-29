<?php

namespace App\Messenger;

use Symfony\Component\Messenger\Stamp\StampInterface;

class UniqueIdStamp implements StampInterface
{
    private $uniqId;

    public function __construct()
    {
        $this->uniqId = UniqId();
    }

    public function getUniqId(): string
    {
        return $this->uniqId;
    }

}