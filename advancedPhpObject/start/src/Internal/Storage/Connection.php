<?php

namespace App\Internal\Storage;

class Connection
{
    private  $configuration;

    public function __construct(array $dbConfiguration)
    {
        $this->configuration = $dbConfiguration;

        /*$this->dbDns = $dbConfiguration['dbDns'];
        $this->dbName = $dbConfiguration['dbName'];
        $this->dbUser = $dbConfiguration['dbUser'];
        $this->dbPassword = $dbConfiguration['dbPassword'];*/
    }

    public function getPdo(): \PDO
    {
        /*if ($this->pdo === null) {
            $this->pdo = new \PDO(
                $this->dbDns.$this->dbName,
                $this->dbUser,
                $this->dbPassword
            );
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }

        return $this->pdo;*/
    }
}
