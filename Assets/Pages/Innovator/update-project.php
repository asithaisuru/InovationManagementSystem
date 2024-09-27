<?php
require_once '../Classes/Innovator.php';
session_start();
if (!isset($_SESSION['username'])) {
    header('location: ../../../index.php');
} else {
    $username = $_SESSION['username'];
    $innovator = new Innovator($username, null);
}

include '../dbconnection.php';
$pid = $_POST['pid2nd'];
$dbnoOfTasks = $innovator->getNoOfTasksForAProject($connection, $pid);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pname = $_POST['pname'];
    $pdis = $_POST['pdis'];
    $projectCategory = $_POST['projectCategory'];
    $edate = $_POST['edate'];
    $numOfTasks = $_POST['taskCount'];

    $innovator->updateProject($connection, $pname, $pdis, $numOfTasks, $edate, $projectCategory, $username, $pid, $dbnoOfTasks);
}