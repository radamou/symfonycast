<?php

namespace KnpU\Domain\Battle;

use KnpU\Domain\Common\BaseRepository;

class BattleRepository extends BaseRepository
{
    protected function getClassName(): string
    {
        return 'KnpU\Domain\Battle\Battle';
    }

    protected function getTableName(): string
    {
        return 'battle';
    }

    protected function finishHydrateObject($obj)
    {
        // normalize the date back to an object
        $this->normalizeDateProperty('foughtAt', $obj);

        // cast into a boolean
        $obj->didProgrammerWin = (bool) $obj->didProgrammerWin;
    }
}
