<?php

require './../bootstrap.php';

use Service\Container;

$container = new Container($config);
$projectManager = $container->getProjectManager();
$theProject = $projectManager->getProject($_GET['id']) ?: header('Location: /');
$groupsManager = $container->getGroupsManager();
$groups = $groupsManager->getGroups($theProject->getProjectId());
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>NFQ Internship - Teachers Task</title>
    <link rel="stylesheet" href="css/main.css">
    <script src="js/main.js" defer></script>
</head>
<body>
<div class="container">
    <div class="project-info">
        <h1><span class="text-black">Project</span> <?= $theProject->getName() ?></h1>
        <p>Number of groups: <span class="text-red"><?= $theProject->getGroupsTotal() ?></span></p>
        <p>Students per group: <span class="text-red"><?= $theProject->getStudentsPerGroup() ?></span></p>
    </div>
    <div class="students-list">
        <h1>Students</h1>
        <div class="groups-control">
            <div class="student-box">
                <div class="box-header">
                    Student Full name
                </div>
                ...
            </div>
        </div>
    </div>
    <div class="groups">
        <h1>Groups</h1>
        <div class="groups-control">
            <?php foreach ($groups as $group): ?>
                <div class="group-box">
                    <div class="box-header">
                        <?= $group['name'] ?>
                    </div>
                    <?= $group['student_id'] ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

</body>
</html>