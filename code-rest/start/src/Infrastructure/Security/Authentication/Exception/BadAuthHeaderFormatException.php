<?php

namespace KnpU\Infrastructure\Security\Authentication\Exception;

use Symfony\Component\Security\Core\Exception\AuthenticationException;

class BadAuthHeaderFormatException extends AuthenticationException
{
    public function getMessageKey(): string
    {
        return 'Malformed Authorization header format';
    }
}
