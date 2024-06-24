<?php

session_start();
if (isset($_SESSION['username']) || isset($_SESSION['role'])) {
    $username = $_SESSION['username'];
    $role = $_SESSION['role'];
} else {
    // header("Location: ../../../index.php");
    echo "<script>window.location.href='../../../index.php';</script>";
    exit();
}

include '../dbconnection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userName = $_POST['viewUserName'];
    $rating = $_POST['rating'];
    $ratingBy = $username;
    $comment = $_POST['review'];

    $query = "INSERT INTO user_ratings (userName, rating, ratingBy, comment) VALUES ('$userName', '$rating', '$ratingBy', '$comment')";
    $result = mysqli_query($connection, $query);
    if ($result) {
        header("Location: ./view-profile.php?userName=$userName&ratingstatus=success");
        exit();
    } else {
        // echo "$connection->error";
        header("Location: ./view-profile.php?userName=$userName&ratingstatus=error");
        exit();
    }
}