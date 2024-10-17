<?php

class Post {
    private $connection;

    public function __construct($dbConnection) {
        $this->connection = $dbConnection;
    }

    // Method to get posts by category
    public function getPosts($category = 'all', $limit = 8) {
        // Default SQL query to fetch all posts
        $sql = "SELECT * FROM posts";

        // Modify query based on category if it's not 'all'
        if ($category != 'all') {
            $category = mysqli_real_escape_string($this->connection, $category);
            $sql .= " WHERE category='$category'";
        }

        // Append ordering and limit to the query
        $sql .= " ORDER BY date DESC LIMIT " . intval($limit);

        // Execute query and return results
        $result = mysqli_query($this->connection, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            return $result;
        } else {
            return null;  // Return null if no posts are found
        }
    }

    // Method to check if a user has liked a post
    public function isPostLiked($postid, $username) {
        $likedQuery = "SELECT * FROM post_likes WHERE post_id='$postid' AND user_id='$username'";
        $likedResult = mysqli_query($this->connection, $likedQuery);

        return mysqli_num_rows($likedResult) > 0;
    }

    // Method to get the number of likes for a post
    public function getLikeCount($postid) {
        $likeCountQuery = "SELECT COUNT(*) AS like_count FROM post_likes WHERE post_id='$postid'";
        $likeCountResult = mysqli_query($this->connection, $likeCountQuery);
        $likeCountRow = mysqli_fetch_assoc($likeCountResult);

        return $likeCountRow['like_count'];
    }
}

?>
