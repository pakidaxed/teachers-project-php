<?php

namespace Model;


class Project
{
    private int $projectId;
    private string $projectName;
    private int $groupsTotal;
    private int $studentsPeGroup;

    public function __construct($projectData)
    {
        $this->projectId = $projectData['id'];
        $this->projectName = $projectData['project_name'];
        $this->groupsTotal = $projectData['groups_total'];
        $this->studentsPeGroup = $projectData['students_per_group'];
    }


    public function getProjectId(): int
    {
        return $this->projectId;
    }

    public function getName(): string
    {
        return $this->projectName;
    }

    public function getGroupsTotal(): int
    {
        return $this->groupsTotal;
    }

    public function getStudentsPerGroup(): int
    {
        return $this->studentsPeGroup;
    }
}

