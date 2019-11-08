<?php

namespace KnpU\Domain\Programmer;

use KnpU\Domain\Common\BaseRepository;
use KnpU\Domain\User\User;

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

    protected function getClassName(): string
    {
        return 'KnpU\Domain\Programmer\Programmer';
    }

    protected function getTableName(): string
    {
        return 'programmer';
    }
}
