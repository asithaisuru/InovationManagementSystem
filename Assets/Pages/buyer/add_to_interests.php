<?php
session_start();
include '../dbconnection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $post_id = $_POST['post_id'];

    // Check if the post is already in interests
    $checkQuery = "SELECT * FROM buyer_interests WHERE buyer_username='$username' AND post_id='$post_id'";
    $checkResult = mysqli_query($connection, $checkQuery);

    if (mysqli_num_rows($checkResult) == 0) {
        // Insert into buyer_interests table
        $insertQuery = "INSERT INTO buyer_interests (buyer_username, post_id) VALUES ('$username', '$post_id')";
        if (mysqli_query($connection, $insertQuery)) {
            echo 'added';
        } else {
            echo 'failed';
        }
    } else {
        echo 'already';
    }
}
?>