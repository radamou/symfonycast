<?php

namespace App\MessageHandler;

use App\Message\DeleteImagePost;
use App\Photo\PhotoFileManager;
use App\Repository\ImagePostRepository;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\NullLogger;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;

class DeleteImagePostHandler implements MessageHandlerInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    private $photoManager;
    private $entityManager;
    private $imagePostRepository;

    public function __construct(
        PhotoFileManager $photoManager,
        EntityManagerInterface $entityManager,
        ImagePostRepository $imagePostRepository
    )
    {
        $this->photoManager = $photoManager;
        $this->entityManager = $entityManager;
        $this->imagePostRepository = $imagePostRepository;
        $this->logger = $this->logger ?? new NullLogger();
    }

    public function __invoke(DeleteImagePost $deleteImagePost)
    {
        $imagePost = $this->imagePostRepository->find(
            $deleteImagePost->getImagePostId()
        );

        if(!$imagePost) {
            $this->logger->alert("Image not exitst for delete action");
        }

        $this->photoManager->deleteImage($imagePost->getFilename());

        $this->entityManager->remove($imagePost);
        $this->entityManager->flush();
    }

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}