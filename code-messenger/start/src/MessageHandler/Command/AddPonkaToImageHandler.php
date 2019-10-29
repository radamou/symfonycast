<?php

namespace App\MessageHandler\Command;

use App\Message\Command\AddPonkaToImage;
use App\Photo\PhotoFileManager;
use App\Photo\PhotoPonkaficator;
use App\Repository\ImagePostRepository;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerAwareTrait;

class AddPonkaToImageHandler implements MessageHandlerInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    /** @var PhotoFileManager */
    private $photoManager;
    /** @var EntityManagerInterface */
    private $entityManager;
    /** @var PhotoPonkaficator*/
    private $ponkaficator;
    /** @var ImagePostRepository */
    private $imagePostRepository;

    public function __construct(
        PhotoFileManager $photoManager,
        EntityManagerInterface $entityManager,
        PhotoPonkaficator $ponkaficator,
        ImagePostRepository $imagePostRepository
    ) {

        $this->photoManager = $photoManager;
        $this->entityManager = $entityManager;
        $this->ponkaficator = $ponkaficator;
        $this->imagePostRepository = $imagePostRepository;
        $this->logger = $this->logger ?? new NullLogger();
    }

    public function __invoke(AddPonkaToImage $addPonkaToImage)
    {
        $imagePost = $this->imagePostRepository->find(
            $addPonkaToImage->getImagePostId()
        );

        if(!$imagePost) {
            $this->logger->alert("There is no image");
        }

        $updatedContents = $this->ponkaficator->ponkafy(
            $this->photoManager->read($imagePost->getFilename())
        );

        $this->photoManager->update($imagePost->getFilename(), $updatedContents);
        $imagePost->markAsPonkaAdded();
        $this->entityManager->flush();
    }

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}
