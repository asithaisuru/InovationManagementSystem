<?php
if (isset($_SESSION['username']) && isset($_SESSION['role'])) {
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

?>

<?php
session_start();
include '../dbconnection.php';

if (isset($_POST['post_id']) && isset($_SESSION['username'])) {
    $post_id = intval($_POST['post_id']);
    $username = $_SESSION['username'];

    // Check if the user has already liked the post
    $check_like = "SELECT * FROM post_likes WHERE post_id = $post_id AND userName = '$username'";
    $result = mysqli_query($connection, $check_like);

    if ($result && mysqli_num_rows($result) > 0) {
        echo "You have already liked this post.";
    } else {
        // Insert like into the database
        $insert_like = "INSERT INTO post_likes (post_id, userName) VALUES ($post_id, '$username')";
        if (mysqli_query($connection, $insert_like)) {
            echo "Post liked successfully.";
        } else {
            echo "Error liking the post.";
        }
    }
} else {
    echo "Invalid request.";
}
