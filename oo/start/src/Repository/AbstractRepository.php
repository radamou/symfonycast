<?php

namespace App\Repository;

use App\Internal\Db\Connection;

abstract class AbstractRepository
{
    protected $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

}