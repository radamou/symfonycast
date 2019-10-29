<?php

namespace App\MessageHandler\Command;

use App\Message\Command\DeleteImagePost;
use App\Message\Event\ImagePostDeletedEvent;
use App\Repository\ImagePostRepository;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\NullLogger;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class DeleteImagePostHandler implements MessageSubscriberInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    private $entityManager;
    private $imagePostRepository;
    private $eventBus;

    public function __construct(
        EntityManagerInterface $entityManager,
        ImagePostRepository $imagePostRepository,
        MessageBusInterface $eventBus
    ) {
        $this->entityManager = $entityManager;
        $this->imagePostRepository = $imagePostRepository;
        $this->logger = $this->logger ?? new NullLogger();
        $this->eventBus = $eventBus;
    }

    public function __invoke(DeleteImagePost $deleteImagePost)
    {
        $imagePost = $this->imagePostRepository->find(
            $deleteImagePost->getImagePostId()
        );

        if(!$imagePost) {
            $this->logger->alert("Image not exitst for delete action");
        }

        $this->entityManager->remove($imagePost);
        $this->entityManager->flush();

        $this->eventBus->dispatch(new ImagePostDeletedEvent($imagePost->getFilename()));
    }

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @inheritDoc
     */
    public static function getHandledMessages(): iterable
    {
             yield DeleteImagePost::class => [
              'method' => '__invoke',
              'priority' => 10,
              //'bus' => 'my_bus_name',
              //'from_transport' => 'async',
         ];
    }
}
