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
$skill = filter_var($_POST['skill-input'], FILTER_SANITIZE_STRING);
// Insert user skills into database
$sql = "INSERT INTO user_skills (userName,skill) VALUES ('$username','$skill')";
//showing response messages
if ($connection->query($sql) === TRUE) {
    $em = "Skill update successfully.";
    header("Location: ./profile.php?status=success&msg=$em");
} else {
    $em = "Skill update failed.";
    header("Location: ./profile.php?status=error&msg=$em");
}
{

$connection->close();
}