<?php

namespace App\Content\Repository;

use App\Internal\Storage\Connection;
use App\Internal\Storage\LoaderInterface;

abstract class AbstractRepository implements LoaderInterface
{
    protected $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }
}