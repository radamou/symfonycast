<?php

namespace KnpU\CodeBattle\Model;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Serializer\ExclusionPolicy("all")
 */
class Programmer
{
    /* All public properties are persisted */
    public $id;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="Please enter a clever nickname")
     * @Serializer\Expose
     */
    public $nickname;

    /**
     * Number of an avatar, from 1-6.
     *
     * @var int
     * @Serializer\Expose
     */
    public $avatarNumber;

    /**
     * @var self
     * @Serializer\Expose
     */
    public $tagLine;

    public $userId;

    /**
     * @var int
     * @Serializer\Expose
     */
    public $powerLevel = 0;

    public function __construct($nickname = null, $avatarNumber = null)
    {
        $this->nickname = $nickname;
        $this->avatarNumber = $avatarNumber;
    }
}
