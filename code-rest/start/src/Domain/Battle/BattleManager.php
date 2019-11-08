<?php

namespace KnpU\Domain\Battle;

use KnpU\Domain\Model\Battle;
use KnpU\Domain\Model\Programmer;
use KnpU\Domain\Model\Project;
use KnpU\Domain\Repository\BattleRepository;
use KnpU\Domain\Repository\ProgrammerRepository;

class BattleManager
{
    private $battleRepository;

    private $programmerRepository;

    public function __construct(BattleRepository $battleRepository, ProgrammerRepository $programmerRepository)
    {
        $this->battleRepository = $battleRepository;
        $this->programmerRepository = $programmerRepository;
    }

    public function battle(Programmer $programmer, Project $project): Battle
    {
        $battle = new Battle();
        $battle->programmer = $programmer;
        $battle->project = $project;
        $battle->foughtAt = new \DateTime();

        if ($programmer->powerLevel < $project->difficultyLevel) {
            // not enough energy
            $battle->didProgrammerWin = false;
            $battle->notes = 'You don\'t have the skills to even start this project. Read the documentation (i.e. power up) and try again!';
        } else {
            if (2 != \rand(0, 2)) {
                $battle->didProgrammerWin = true;
                $battle->notes = 'You battled heroically, asked great questions, worked pragmatically and finished on time. You\'re a hero!';
            } else {
                $battle->didProgrammerWin = false;
                $battle->notes = 'Requirements kept changing, too many meetings, project failed :(';
            }

            $programmer->powerLevel = $programmer->powerLevel - $project->difficultyLevel;
        }

        $this->battleRepository->save($battle);
        $this->programmerRepository->save($programmer);

        return $battle;
    }
}
