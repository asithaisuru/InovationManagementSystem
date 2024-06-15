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


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum</title>
    <style>
        #backToTopBtn {
            display: none;
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 100;
        }
    </style>
</head>

<body class="bg-dark text-white">
    <?php include '../Innovator/innovator-nav.php'; ?>

    <body>

    <div class="container">

        <h1 class="text-center">Welcome to the Innovator Forum</h1>
        <p class="text-center">A space for sharing success stories, seeking collaborators, and exchanging insights into
            the innovation process.</p>
            <div>
                <a href="./submit-form.php" class="btn btn-success">Create your story</a>
            </div> <br>
            <div class="card-body border-3 border-white bg-dark mb-3">
                <h4>Category</h4>
                <form method="GET">
                <select name="post_category" id="post_category" class="form-control" required onchange="filterPosts(this.value)">
                    <option value="all">All</option>
                    <?php
                    $categories = [
                        'Success_Stories' => 'Success Stories',
                        'Collaboration_Opportunities' => 'Collaboration Opportunities',
                        'Insights_and_Tips' => 'Insights and Tips',
                        'Skills_and_Qualifications' => 'Skills and Qualifications',
                        'Personal_Branding' => 'Personal Branding'
                    ];
                    foreach ($categories as $value => $label) {
                        echo "<option value='$value'>$label</option>";
                    }
                    ?>
                </select> <br>
                <button class="btn btn-primary" type="submit">Search Posts</button>
                </form>
            </div>
            

        <!-- Display Posts -->
        <?php
        $sql = "SELECT * FROM posts";
        if (isset($_GET['post_category']) && $_GET['post_category'] != 'all') {
            $category = mysqli_real_escape_string($connection, $_GET['post_category']);
            $sql .= " WHERE category='$category'";
        }
        $sql .= " ORDER BY date DESC LIMIT 8";
        $result = mysqli_query($connection, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='card bg-dark text-white border-1 border-white p-3 mb-3'>";
                echo "<h3>" . $row['title'] . "</h3>";
                echo "<p>" . $row['content'] . "</p>";
                echo "<small>Posted by: <a class='text-white' href='../Innovator/view-profile.php?userName=" . $row['userName'] . "'>" . $row['userName'] . "</a></small>";
                echo "<small>Posted on: " . (isset($row['date']) ? date('F j, Y', strtotime($row['date'])) : date('F j, Y')) . "</small>";
                echo "<small>Posted at: <span id='post-time'>" . (isset($row['date']) ? date('h:i A', strtotime($row['date'])) : date('h:i A', time())) . "</span></small>";
                echo "<small>Category: " . htmlspecialchars($row['category']) . "</small>";
                echo "<div class='d-flex justify-content-between mt-3'>";
                if (isset($row['post_id'])) {
                    echo "<button class='btn btn-primary' id='like-btn-" . $row['post_id'] . "' onclick='likePost(" . $row['post_id'] . ")'>Like</button>";
                } else {
                    echo "<button class='btn btn-primary' onclick='likePost()'>Like</button>";
                }
                if (isset($row['post_id'])) {
                    echo "<button class='btn btn-secondary' id='comment-btn-" . $row['post_id'] . "' onclick='toggleCommentBox(" . $row['post_id'] . ")'>Comments</button>";
                } else {
                    echo "<button class='btn btn-secondary' onclick='toggleCommentBox()'>Comments</button>";
                }
                echo "<div class='d-flex justify-content-between mt-3'>";
                echo "<div id='comment-box-" . (isset($row['post_id']) ? $row['post_id'] : '') . "' style='display: none;'>";
                echo "<form id='comment-form-" . $row['post_id'] . "' onsubmit='submitComment(event, " . $row['post_id'] . ")'>";
                echo "<input type='text' name='comment' placeholder='Enter your comment...' required>";
                echo "<button type='submit'>Submit</button>";
                echo "</form>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "No posts found";
        }
        ?>
    </div>

    <button id="backToTopBtn" class="btn btn-success rounded-circle p-3">Top</button>

    <script>
        // Show the button when the user scrolls down 20px from the top
        window.onscroll = function() {
            scrollFunction();
        };

        function scrollFunction() {
            if (document.body.scrollTop > 450 || document.documentElement.scrollTop > 450) {
                document.getElementById("backToTopBtn").style.display = "block";
            } else {
                document.getElementById("backToTopBtn").style.display = "none";
            }
        }

        document.getElementById('backToTopBtn').addEventListener('click', function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

            //-----------------Filter Posts-----------------

        function likePost(postId) {
            fetch('like_post.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ 'post_id': postId })
            })
            .then(response => response.text())
            .then(data => alert(data))
            .catch(error => alert('An error occurred while liking the post.'));
        }

        function toggleCommentBox(postId) {
            const commentBox = document.getElementById('comment-box-' + postId);
            commentBox.style.display = commentBox.style.display === 'none' ? 'block' : 'none';
        }

        function submitComment(event, postId) {
            event.preventDefault();
            const form = document.getElementById('comment-form-' + postId);
            const formData = new FormData(form);
            formData.append('post_id', postId);

            fetch('comment_post.php', {
                method: 'POST',
                body: new URLSearchParams(formData)
            })
            .then(response => response.text())
            .then(data => {
                alert(data);
                form.reset();
            })
            .catch(error => alert('An error occurred while submitting the comment.'));
        }
        </script>

    <div id="footer">
        <?php include '../footer.php'; ?>
    </div>


</body>

</html>
