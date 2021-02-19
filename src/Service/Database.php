<?php


namespace Service;


class Database
{
    private \PDO $pdo;

    public function __construct()
    {
        $this->pdo = $this->setPdo();
    }

    private function setPdo(): \PDO
    {
        $pdo = new \PDO('mysql:host=172.23.0.2;dbname=nfq_task', 'root', 'secret');
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        return $pdo;
    }

}