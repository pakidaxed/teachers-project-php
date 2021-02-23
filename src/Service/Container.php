<?php


namespace Service;


class Container
{
    private array $config;
    private ?\PDO $pdo = null;
    private ?ProjectManager $projectManager = null;
    private ?GroupsManager $groupsManager = null;
    private ?StudentManager $studentManager = null;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function getPDO(): \PDO
    {
        if ($this->pdo === null) {

            $this->pdo = new \PDO(
                $this->config['db_dsn'],
                $this->config['db_user'],
                $this->config['db_pass']
            );
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }

        return $this->pdo;
    }

    public function getProjectManager(): ?ProjectManager
    {
        if ($this->projectManager === null) {
            $this->projectManager = new ProjectManager($this->getPDO());
        }

        return $this->projectManager;
    }

    public function getGroupsManager(): ?GroupsManager
    {
        if ($this->groupsManager === null) {
            $this->groupsManager = new GroupsManager($this->getPDO());
        }

        return $this->groupsManager;
    }

    public function getStudentManager(): ?StudentManager
    {
        if ($this->studentManager === null) {
            $this->studentManager = new StudentManager($this->getPDO());
        }

        return $this->studentManager;
    }

}