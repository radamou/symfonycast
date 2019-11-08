<?php

namespace KnpU\Domain\Battle;

use KnpU\Domain\Programmer\Programmer;
use KnpU\Domain\Project\Project;

class Battle
{
    /* All public properties are persisted */
    public $id;

    /** @var Programmer */
    public $programmer;

    /** @var Project */
    public $project;

    public $didProgrammerWin;

    public $foughtAt;

    public $notes;
}
