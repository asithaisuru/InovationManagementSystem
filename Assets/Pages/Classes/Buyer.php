<?php
require_once "User.php";

 function getInterests($username)
    {
        $query = "
            SELECT posts.postid, posts.title, posts.content, posts.date 
            FROM posts 
            INNER JOIN Buyer_Interests ON posts.postid = Buyer_Interests.post_id 
            WHERE Buyer_Interests.buyer_username = ? 
            ORDER BY posts.date DESC";

        $stmt = connection->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        $interests_posts = [];
        while ($row = $result->fetch_assoc()) {
            $interests_posts[] = $row;
        }
        $stmt->close();

        return $interests_posts;
    }

    function addToInterests($username, $post_id)
    {

        $checkQuery = "SELECT * FROM buyer_interests WHERE buyer_username='$username' AND post_id='$post_id'";
        $checkResult = mysqli_query(conn -> $checkQuery);

       
    }

     function viewProjects($username)
    {
        $query = "SELECT postid, title, content, date FROM posts ORDER BY date DESC LIMIT 3";
        $result = conn -> query ($query);

        $recent_posts = [];
        while ($row = $result->fetch_assoc()) {
            $recent_posts[] = $row;
        }

        return $recent_posts;
    }

?>
