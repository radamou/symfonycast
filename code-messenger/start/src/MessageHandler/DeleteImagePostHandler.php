<?php

namespace App\MessageHandler;

use App\Message\DeleteImagePost;
use App\Message\DeletePhotoFile;
use App\Repository\ImagePostRepository;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\NullLogger;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class DeleteImagePostHandler implements MessageHandlerInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    private $entityManager;
    private $imagePostRepository;
    private $messageBus;

    public function __construct(
        EntityManagerInterface $entityManager,
        ImagePostRepository $imagePostRepository,
        MessageBusInterface $messageBus
    ) {
        $this->entityManager = $entityManager;
        $this->imagePostRepository = $imagePostRepository;
        $this->logger = $this->logger ?? new NullLogger();
        $this->messageBus = $messageBus;
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

        $this->messageBus->dispatch(new DeletePhotoFile($imagePost->getFilename()));
    }

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}