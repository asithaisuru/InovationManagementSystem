<?php
session_start();
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    // header("Location: ../../../index.php");
    echo "<script>window.location.href='../../../index.php';</script>";
    exit();
}

include '../dbconnection.php';

if (isset($_POST['id'])) {
    $skill_id = $_POST['id'];
    require_once '../Classes/Administrator.php';
    $admin = new Administrator($username, null);
    echo $admin->deleteSkill($connection, $skill_id);
} else {
    echo 'error';
}
?>