<?php


namespace Service;


class GroupsManager
{
    private \PDO $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getGroups($id): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM Grouped WHERE project_id = $id");
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

}