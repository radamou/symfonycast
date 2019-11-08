<?php

namespace KnpU\Domain\Repository;

use KnpU\Domain\Model\Programmer;
use KnpU\Domain\Model\User;

class ProgrammerRepository extends BaseRepository
{
    /**
     * @param $nickname
     *
     * @return Programmer
     */
    public function findOneByNickname($nickname)
    {
        return $this->findOneBy(['nickname' => $nickname]);
    }

    public function findAllForUser(User $user)
    {
        return $this->findAllBy(['userId' => $user->id]);
    }

    protected function getClassName()
    {
        return 'KnpU\CodeBattle\Model\Programmer';
    }

    protected function getTableName()
    {
        return 'programmer';
    }
}
