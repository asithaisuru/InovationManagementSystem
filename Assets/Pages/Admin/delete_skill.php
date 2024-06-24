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
    $delete_sql = "DELETE FROM `user_skills` WHERE id = '"$skill_id.."' ";
    if (mysqli_query($connection, $delete_sql)) {
        echo 'success';
    } else {
        echo 'error';
    }
} else {
    echo 'error';
}
?>

