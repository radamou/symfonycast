<?php

namespace App\Message;

use App\Entity\ImagePost;

class AddPonkaToImage implements  AsyncMessageInterface
{
    private $imagePostId;

    public function __construct(int $imagePostId) {
        $this->imagePostId = $imagePostId;
    }

    public function getImagePostId(): int
    {
        return $this->imagePostId;
    }
}