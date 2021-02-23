<?php

require './../bootstrap.php';

use Service\Container;

$container = new Container($config);
$projectManager = $container->getProjectManager();
$theProject = $projectManager->getProject($_GET['id']) ?: header('Location: /');

$groupsManager = $container->getGroupsManager();
$groups = $groupsManager->getGroups($theProject->getProjectId());

$studentManager = $container->getStudentManager();
if (isset($_POST) && isset($_POST['new_student_name'])) $studentManager->addNewStudent($_POST['new_student_name'], $theProject->getProjectId());
if (isset($_POST) && isset($_POST['student_id'])) $studentManager->assignStudent($_POST);
if (isset($_GET) && isset($_GET['action']) && ($_GET['action'] === 'delete') && isset($_GET['student_id'])) $studentManager->deleteStudent($_GET['student_id']);
$students = $studentManager->getStudents($theProject->getProjectId());

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
        <h1>Students
            <button onclick="openAddNewStudent()">Add new student</button>
        </h1>
        <div class="add-new-student" id="new_student">
            <form method="post">
                <label for="new_student_name">New student name:</label>
                <input type="text" name="new_student_name" id="new_student_name"/>
                <button class="d-block">Add</button>
            </form>
        </div>
        <table>
            <thead>
            <tr>
                <th>Student name</th>
                <th>Student group</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($students as $student): ?>
                <tr>
                    <td><?= htmlspecialchars($student['name']) ?></td>

                    <td><?= $groupsManager->getGroupedName($student['group_id']) ?: '-' ?></td>
                    <td>
                        <a href="<?= $_SERVER['REQUEST_URI'] ?>&action=delete&student_id=<?= $student['id'] ?>">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="groups">
        <h1>Groups</h1>
        <div class="groups-control">
            <?php foreach ($groups as $group): ?>
                <table id="groups">
                    <thead>
                    <tr>
                        <th><?= $group['name'] ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $assignedStudents = array_filter($students, function ($student) {
                        return $student['group_id'];
                    }); ?>
                    <?php $availableStudents = array_filter($students, function ($student) {
                        return !$student['group_id'];
                    }); ?>
                    <?php for ($i = 1; $i <= $theProject->getStudentsPerGroup(); $i++): ?>
                        <tr>
                            <td>
                                <?php
                                $studentName = null;
                                foreach ($assignedStudents as $assignedStudent) {
                                    if ($assignedStudent['position'] == $i && $assignedStudent['group_id'] == $group['id']) {
                                        $studentName = $assignedStudent['name'];
                                    }
                                }
                                if ($studentName): ?>
                                    <?= $studentName ?>
                                <?php else: ?>
                                    <form method="post" action="<?= $_SERVER['REQUEST_URI'] ?>">
                                        <input type="hidden" name="action" value="assign">
                                        <input type="hidden" name="group_id" value="<?= $group['id'] ?>">
                                        <input type="hidden" name="position" value="<?= $i ?>">
                                        <label>
                                            <select name="student_id" id="student_id" onchange="this.form.submit()">
                                                <option value="null">Assign student</option>
                                                <?php foreach ($availableStudents as $availableStudent): ?>
                                                    <option value="<?= $availableStudent['id'] ?>"><?= $availableStudent['name'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </label>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endfor; ?>
                    </tbody>
                </table>
            <?php endforeach; ?>
        </div>
    </div>
    <footer>(c) Tomas Jucius 2020</footer>
</body>
</html>