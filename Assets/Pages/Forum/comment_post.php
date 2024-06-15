<?php
session_start();
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

if (isset($_POST['post_id']) && isset($_POST['comment']) && isset($_SESSION['username'])) {
    $post_id = intval($_POST['post_id']);
    $comment = mysqli_real_escape_string($connection, $_POST['comment']);
    $username = $_SESSION['username'];

    // Insert comment into the database
    $insert_comment = "INSERT INTO post_comments (post_id, userName, comment) VALUES ($post_id, '$username', '$comment')";
    if (mysqli_query($connection, $insert_comment)) {
        echo "Comment submitted successfully.";
    } else {
        echo "Error submitting the comment.";
    }
} else {
    echo "Invalid request.";
}
?>
