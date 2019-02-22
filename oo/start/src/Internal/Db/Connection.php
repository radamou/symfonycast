<?php

namespace App\Internal\Db;

class Connection implements ConnectionInterface
{
    private $dbDns;
    private $dbName;
    private $dbUser;
    private $dbPassword;
    private $pdo;

    public function __construct(array $dbConfiguration)
    {
        $this->dbDns = $dbConfiguration['dbDns'];
        $this->dbName = $dbConfiguration['dbName'];
        $this->dbUser = $dbConfiguration['dbUser'];
        $this->dbPassword = $dbConfiguration['dbPassword'];
    }

    public function getPdo(): PDO
    {
        if ($this->pdo === null) {
            $this->pdo = new PDO(
                $this->dbDns.$this->dbName,
                $this->dbUser,
                $this->dbPassword
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return $this->pdo;
    }


    public function getDbName(): string
    {
        return $this->dbName;
    }


    public function setDbName(string $dbName): self
    {
        $this->dbName = $dbName;

        return $this;
    }

    public function getDbUser(): string
    {
        return $this->dbUser;
    }


    public function setDbUser(string $dbUser): self
    {
        $this->dbUser = $dbUser;

        return $this;
    }

    public function getDbPassword(): string
    {
        return $this->dbPassword;
    }


    public function setDbPassword(string $dbPassword): self
    {
        $this->dbPassword = $dbPassword;

        return $this;
    }
}