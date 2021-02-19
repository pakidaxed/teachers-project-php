<?php

require './../../bootstrap.php';

use Service\Container;

$container = new Container($config);
$projectManage = $container->getProjectManager();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $content = trim(file_get_contents("php://input"));
    $decoded = json_decode($content, true);

    $projectManage->addProject($decoded);
} else {
    echo json_encode($projectManage->checkForProjects());
}