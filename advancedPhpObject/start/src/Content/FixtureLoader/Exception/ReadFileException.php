<?php

namespace App\Content\FixtureLoader\Exception;

use Safe\Exceptions\FilesystemException;
use Throwable;

class ReadFileException extends FilesystemException
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
