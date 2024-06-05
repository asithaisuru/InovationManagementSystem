<?php
session_start();
if (isset($_SESSION['username']) || isset($_SESSION['role'])) {
    $username = $_SESSION['username'];
    $role = $_SESSION['role'];
    if ($role != 'Innovator') {
        echo "<script>window.location.href='../../../index.php';</script>";
        exit();
    }
} else {
    // header("Location: ../../../index.php");
    echo "<script>window.location.href='../../../index.php';</script>";
    exit();
}

include '../dbconnection.php';

$taskID = isset($_GET['taskID']) ? htmlspecialchars($_GET['taskID']) : "";
$status = $_POST['status'];
$sql = "UPDATE tasks SET status = '$status' WHERE taskID = '$taskID'";
$result = mysqli_query($connection, $sql);
if ($result) {
    echo "<script>window.location.href='./project-details.php?taskstatusupdate=success';</script>";
    exit();
} else {
    echo "<script>window.location.href='./project-details.php?taskstatusupdate=error';</script>";
    exit();
}