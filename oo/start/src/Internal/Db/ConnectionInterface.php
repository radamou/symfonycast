<?php

namespace App\Internal\Db;

interface ConnectionInterface
{
    public function getPdo(): PDO;
}