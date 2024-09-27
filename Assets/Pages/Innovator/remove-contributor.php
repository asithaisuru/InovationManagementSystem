<?php
require_once "../Classes/Innovator.php";
session_start();
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $role = $_SESSION['role'];
    if ($role != 'Innovator' && $role != "Admin") {
        echo "<script>window.location.href='../../../sign-in.php';</script>";
        exit();
    }
    $innovator = new Innovator($username, null);
} else {
    // header("Location: ../../../index.php");
    echo "<script>window.location.href='../../../sign-in.php';</script>";
    exit();
}

$pid = isset($_GET['pid']) ? htmlspecialchars($_GET['pid']) : "";
$assignedTo = isset($_GET['userName']) ? htmlspecialchars($_GET['userName']) : "";

include '../dbconnection.php';

$innovator->removeContributor($connection, $pid, $assignedTo, $role);