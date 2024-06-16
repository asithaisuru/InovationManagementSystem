<?php
session_start();
include '../dbconnection.php';

if (isset($_POST['postid']) && isset($_SESSION['username'])) {
    $postid = mysqli_real_escape_string($connection, $_POST['postid']);
    $username = mysqli_real_escape_string($connection, $_SESSION['username']);

    // Check if the user has already liked the post
    $checkLikeQuery = "SELECT * FROM post_likes WHERE post_id='$postid' AND user_id='$username'";
    $checkLikeResult = mysqli_query($connection, $checkLikeQuery);

    if (!$checkLikeResult) {
        echo 'Error in checkLikeQuery: ' . mysqli_error($connection);
        exit();
    }

    if (mysqli_num_rows($checkLikeResult) == 0) {
        // If not liked yet, insert the like
        $likeQuery = "INSERT INTO post_likes (post_id, user_id) VALUES ('$postid', '$username')";
        if (mysqli_query($connection, $likeQuery)) {
            echo 'liked';
        } else {
            echo 'Error in likeQuery: ' . mysqli_error($connection);
        }
    } else {
        // If already liked, remove the like
        $unlikeQuery = "DELETE FROM post_likes WHERE post_id='$postid' AND user_id='$username'";
        if (mysqli_query($connection, $unlikeQuery)) {
            echo 'unliked';
        } else {
            echo 'Error in unlikeQuery: ' . mysqli_error($connection);
        }
    }
} else {
    echo 'An error occurred.';
}
?>
