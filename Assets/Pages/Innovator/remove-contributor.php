<?php

session_start();
if (isset($_SESSION['username'])) {
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

$pid = isset($_GET['pid']) ? htmlspecialchars($_GET['pid']) : "";
$userName = isset($_GET['userName']) ? htmlspecialchars($_GET['userName']) : "";

include '../dbconnection.php';

$sql = "DELETE FROM contributors WHERE pid = ? AND userName = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("ss", $pid, $userName);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "<script>window.location.href='./add-contributor.php?removecontributor=success';</script>";
    exit();
} else {
    echo "<script>window.location.href='./add-contributor.php?removecontributor=error';</script>";
    exit();
}
