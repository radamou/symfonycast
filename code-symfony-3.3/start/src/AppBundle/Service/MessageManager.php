<?php

namespace AppBundle\Service;

class MessageManager
{
    private $encouragingMessages = [];
    private $discouragingMessages = [];

    public function __construct(array $encouragingMessages, array $discouragingMessages)
    {
        $this->encouragingMessages = $encouragingMessages;
        $this->discouragingMessages = $discouragingMessages;
    }

    public function getEncouragingMessage()
    {
        return $this->encouragingMessages[\array_rand($this->encouragingMessages)];
    }

    public function getDiscouragingMessage()
    {
        return $this->discouragingMessages[\array_rand($this->discouragingMessages)];
    }
}
