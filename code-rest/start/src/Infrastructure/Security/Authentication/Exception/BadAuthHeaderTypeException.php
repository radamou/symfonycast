<?php

namespace KnpU\Infrastructure\Security\Authentication\Exception;

use KnpU\Infrastructure\Security\Authentication\ApiTokenListener;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class BadAuthHeaderTypeException extends AuthenticationException
{
    public function getMessageKey(): string
    {
        return \sprintf(
            'Unknown Authorization header type = use "%s"',
            ApiTokenListener::AUTHORIZATION_HEADER_TOKEN_KEY
        );
    }
}
