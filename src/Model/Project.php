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


    /**
     * @return int|mixed
     */
    public function getProjectId(): int
    {
        return $this->projectId;
    }

    /**
     * @return mixed|string
     */
    public function getName(): string
    {
        return $this->projectName;
    }

    /**
     * @return int|mixed
     */
    public function getGroupsTotal(): int
    {
        return $this->groupsTotal;
    }

    /**
     * @return int|mixed
     */
    public function getStudentsPerGroup(): int
    {
        return $this->studentsPeGroup;
    }
}

