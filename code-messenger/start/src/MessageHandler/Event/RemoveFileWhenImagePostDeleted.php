<?php

namespace App\MessageHandler\Event;

use App\Message\Event\ImagePostDeletedEvent;
use App\Photo\PhotoFileManager;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class RemoveFileWhenImagePostDeleted implements MessageHandlerInterface
{

    private $manager;

    public function __construct(PhotoFileManager $manager) {
        $this->manager = $manager;
    }

    public function __invoke(ImagePostDeletedEvent $event)
    {
        $this->manager->deleteImage($event->getFileName());
    }
}
