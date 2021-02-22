<?php

namespace Service;


class ProjectManager
{
    private \PDO $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Receiving data from database and returning as json encoded for the index javascript to show the projects list
     *
     * @return array|null
     */
    public function checkForProjects(): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM Projects ORDER BY id DESC ");
        $stmt->execute();

        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $result ?: null;
    }

    public function addProject($data): void
    {
        $stmt = $this->pdo->prepare("INSERT INTO Projects 
    (project_name, groups_total, students_per_group)
 VALUES (:project_name, :groups_total, :students_per_group)");
        $stmt->bindParam(':project_name', $data['project_name']);
        $stmt->bindParam(':groups_total', $data['groups_total']);
        $stmt->bindParam(':students_per_group', $data['students_per_group']);
        $result = $stmt->execute();
        $lastId = $this->pdo->lastInsertId();

        if ($result) {
            for ($i = 1; $i <= $data['groups_total']; $i++) {
                $stmt = $this->pdo->prepare("INSERT INTO Grouped (name, project_id) VALUES (:name, :project_id)");
                $groupName = 'Group #' . $i;
                $stmt->bindParam(':name', $groupName);
                $stmt->bindParam(':project_id', $lastId);
                for ($j = 1; $j <= $data['students_per_group']; $j++) $stmt->execute();
            }
            echo json_encode(['message' => 'Added']);
        } else {
            echo json_encode(['message' => 'Failed']);
        }
    }

}