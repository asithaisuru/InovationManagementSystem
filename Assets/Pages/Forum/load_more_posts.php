<?php
session_start();
include '../dbconnection.php';

$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;

$sql = "SELECT * FROM posts ORDER BY date DESC LIMIT 8 OFFSET $offset";
$result = mysqli_query($connection, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='card bg-dark text-white border-1 border-white p-3 mb-3'>";
        echo "<h3>" . $row['title'] . "</h3>";
        echo "<p>" . $row['content'] . "</p>";
        echo "<small>Posted by: <a class='text-white' href='../Innovator/view-profile.php?userName=" . $row['userName'] . "'>" . $row['userName'] . "</a></small>";
        echo "<small>Posted on: " . (isset($row['date']) ? date('F j, Y', strtotime($row['date'])) : date('F j, Y')) . "</small>";
        echo "<small>Posted at: <span id='post-time'>" . (isset($row['date']) ? date('h:i A', strtotime($row['date'])) : date('h:i A', time())) . "</span></small>";
        echo "<small>Category: " . $row['category'] . "</small>";
        $isLiked = false; 
        echo "<button class='btn btn-sm " . ($isLiked ? "btn-success" : "btn-primary") . " like-btn' data-post-id='" . htmlspecialchars($row['postid']) . "' style='width: 55px;'>" . ($isLiked ? "Liked" : "Like") . "</button>";
        echo "</div>";
    }
} else {
    echo "No more posts to load ..";
}
?>
