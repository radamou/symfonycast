<?php

namespace App\Message;

use App\Entity\ImagePost;

class DeleteImagePost
{
    private $imagePostId;

    public function __construct(int $imagePostId)
    {
        $this->imagePostId = $imagePostId;
    }

    public function getImagePostId(): int
    {
        return $this->imagePostId;
    }
}