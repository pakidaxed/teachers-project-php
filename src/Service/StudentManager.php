<?php


namespace Service;


class StudentManager
{
    private \PDO $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getStudents(?int $projectId): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM students WHERE project_id = $projectId");
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function addNewStudent($studentName, int $project_id)
    {
        $stmt = $this->pdo->prepare("INSERT INTO students (name, project_id) VALUES (:name, :project_id)");
        $stmt->bindParam(':name', $studentName);
        $stmt->bindParam(':project_id', $project_id);
        $stmt->execute();
    }

    public function assignStudent($studentData)
    {
        $stmt = $this->pdo->prepare("UPDATE students SET 
        group_id = :group_id, 
        position = :position
        WHERE id = :student_id
");
        $stmt->bindParam(':group_id', $studentData['group_id']);
        $stmt->bindParam(':position', $studentData['position']);
        $stmt->bindParam(':student_id', $studentData['student_id']);
        $stmt->execute();
    }

    public function deleteStudent($student_id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM students WHERE id = $student_id");
        $stmt->execute();
    }
}