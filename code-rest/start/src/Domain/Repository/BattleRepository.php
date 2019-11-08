<?php

namespace KnpU\Domain\Repository;

class BattleRepository extends BaseRepository
{
    protected function getClassName()
    {
        return 'KnpU\Domain\Model\Battle';
    }

    protected function getTableName()
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
