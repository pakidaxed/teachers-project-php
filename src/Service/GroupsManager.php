<?php


namespace Service;


class GroupsManager
{
    private \PDO $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getGroups(int $project_id): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM Grouped WHERE project_id = $project_id");
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getGroupedName(?int $id): ?string
    {
        if (!$id) return null;
        $stmt = $this->pdo->prepare("SELECT name FROM Grouped WHERE id = $id");
        $stmt->execute();

        return $stmt->fetchColumn() ?: null;
    }


}