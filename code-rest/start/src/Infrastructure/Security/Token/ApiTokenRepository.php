<?php

namespace KnpU\Infrastructure\Security\Token;


use KnpU\Domain\Common\BaseRepository;
use KnpU\Domain\User\User;

class ApiTokenRepository extends BaseRepository
{
    const TABLE_NAME = 'api_token';

    protected function getClassName(): string
    {
        return 'KnpU\Infrastructure\Security\Token\ApiToken';
    }

    protected function getTableName():  string
    {
        return self::TABLE_NAME;
    }

    /**
     * @param $token
     *
     * @return ApiToken
     */
    public function findOneByToken($token)
    {
        return $this->findOneBy(['token' => $token]);
    }

    public function findAllForUser(User $user)
    {
        return $this->findAllBy(['userId' => $user->id]);
    }

    protected function finishHydrateObject($obj)
    {
        $this->normalizeDateProperty('createdAt', $obj);
    }

    /**
     * Overridden to create our ApiToken even though it has a constructor arg.
     *
     * @param string $class
     *
     * @return ApiToken
     */
    protected function createObject($class, array $data)
    {
        return new $class($data['userId']);
    }
}
