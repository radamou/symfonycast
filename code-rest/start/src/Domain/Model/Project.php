<?php

namespace KnpU\Domain\Model;

class Project
{
    /* All public properties are persisted */
    public $id;

    public $name;

    /**
     * 1-10 difficulty level of the project.
     *
     * @var int
     */
    public $difficultyLevel;
}
