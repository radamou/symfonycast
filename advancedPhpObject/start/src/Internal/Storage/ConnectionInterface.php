<?php

namespace App\Internal\Storage;

interface ConnectionInterface
{
    public function getPdo(): \PDO;
}
