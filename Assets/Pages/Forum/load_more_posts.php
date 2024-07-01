<?php
session_start();

// Check if the user is logged in and has the required role
if (isset($_SESSION['username']) && isset($_SESSION['role'])) {
    $username = $_SESSION['username'];
    $role = $_SESSION['role'];
    if ($role != 'Innovator') {
        echo "<script>window.location.href='../../../index.php';</script>";
        exit();
    }
} else {
    echo "<script>window.location.href='../../../index.php';</script>";
    exit();
}

// Include db connection
include '../dbconnection.php';

// Get the offset value from the URL parameter
$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;

// SQL query to fetch posts with the given offset
$sql = "SELECT * FROM posts ORDER BY date DESC LIMIT 8 OFFSET ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $offset);
$stmt->execute();
$result = $stmt->get_result();

// Check if any posts are found
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Check if the current user has liked this post
        $postid = $row['postid'];
        $likedQuery = "SELECT * FROM post_likes WHERE post_id=? AND user_id=?";
        $likedStmt = $connection->prepare($likedQuery);
        $likedStmt->bind_param("ss", $postid, $username);
        $likedStmt->execute();
        $likedResult = $likedStmt->get_result();
        $isLiked = ($likedResult->num_rows > 0);

        // Get the number of likes for this post
        $likeCountQuery = "SELECT COUNT(*) AS like_count FROM post_likes WHERE post_id=?";
        $likeCountStmt = $connection->prepare($likeCountQuery);
        $likeCountStmt->bind_param("s", $postid);
        $likeCountStmt->execute();
        $likeCountResult = $likeCountStmt->get_result();
        
        $likeCountRow = $likeCountResult->fetch_assoc();
        $likeCount = $likeCountRow['like_count'];

        // Display post details
        echo "<div class='card bg-dark text-white border-1 border-white p-3 mb-3'>";
        echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
        echo "<p>" . htmlspecialchars($row['content']) . "</p>";
        echo "<small>Posted by: <a class='text-white' href='../Innovator/view-profile.php?userName=" . htmlspecialchars($row['userName']) . "'>" . htmlspecialchars($row['userName']) . "</a></small>";
        echo "<small>Posted on: " . (isset($row['date']) ? date('F j, Y', strtotime($row['date'])) : date('F j, Y')) . "</small>";
        echo "<small>Posted at: <span id='post-time'>" . (isset($row['date']) ? date('h:i A', strtotime($row['date'])) : date('h:i A', time())) . "</span></small>";
        echo "<small>Category: " . htmlspecialchars($row['category']) . "</small>";
        echo "<div class='d-flex align-items-center'>";
        echo "<button class='btn btn-sm " . ($isLiked ? "btn-success" : "btn-primary") . " like-btn' data-post-id='" . htmlspecialchars($postid) . "' style='width: 55px; margin-top: 5px;'>" . ($isLiked ? "Liked" : "Like") . "</button>";
        echo "<span class='mt-2 ms-2 me-1 like-count .text-white fw-bold' data-post-id='" . htmlspecialchars($postid) . "'>$likeCount</span>";
        echo "<span class='mt-1 ms-0.3 me-2 like-icon animate__animated animate__bounce'><i class='fas fa-thumbs-up .text-white fs-6'></i></span>";
        echo "</div>";
        echo "</div>";
        
    }
     {  // If no posts are found  
        
    }
}
   

?>
