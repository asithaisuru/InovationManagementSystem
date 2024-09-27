<?php
require_once "../Classes/Innovator.php";
session_start();
if (isset($_SESSION['username']) || isset($_SESSION['role'])) {
    $username = $_SESSION['username'];
    $role = $_SESSION['role'];
    $innovator = new Innovator($username, null);
} else {
    // header("Location: ../../../index.php");
    echo "<script>window.location.href='../../../index.php';</script>";
    exit();
}

include '../dbconnection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $innovator->submitRating($connection, $_POST['viewUserName'], $_POST['rating'], $_POST['viewUserName'], $_POST['review']);
}