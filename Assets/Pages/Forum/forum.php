<?php
session_start();
if (isset($_SESSION['username']) || isset($_SESSION['role'])) {
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
</head>

<body class="bg-dark text-white">
    <?php include '../Innovator/innovator-nav.php'; ?>

    <div class="container">

        <h1 class="text-center">Welcome to the Innovator Forum</h1>
        <p class="text-center">A space for sharing success stories, seeking collaborators, and exchanging insights into
            the innovation process.</p>

        <!-- Form to submit a new post -->
        <div class="card bg-light text-white bg-dark mb-4 border-3 border-white">
            <div class="card-body">
                <h2 class="text-center mb-3">Share Your Story or Find Collaborators</h2>
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="post_title">Title</label>
                        <input type="text" name="post_title" id="post_title" class="form-control mb-2" required>
                    </div>
                    <div class="form-group">
                        <label for="post_content">Content</label>
                        <textarea name="post_content" id="post_content" class="form-control mb-2" rows="5"
                            required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="post_category">Category</label> </br>
                        <select name="post_category" id="post_category" class="form-control" required>
                            <option value="SuccessStories">Success Stories</option>
                            <option value="CollaborationOpportunities">Collaboration Opportunities</option>
                            <option value="InsightsandTips">Insights and Tips</option>
                            <option value="InsightsandTips">Skills and Qualifications</option>
                            <option value="InsightsandTips">Personal Branding </option>
                            <option value="InsightsandTips">Insights and Tips</option>
                        </select>
                    </div> <br>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>

        <!-- Display Posts -->
        <div class="section mt-5">
            <h2>Success Stories</h2>
            <p>Read about the latest success stories from our community. Be inspired by the journeys and achievements of
                fellow innovators.</p>
            <?php
            $sql = "SELECT * FROM posts WHERE category='SuccessStories' ORDER BY created_at DESC;";
            $result = mysqli_query($connection, $sql);
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='post'>";
                    echo "<h3>" . $row['title'] . "</h3>";
                    echo "<p>" . $row['content'] . "</p>";
                    echo "<small>Posted by: " . $row['username'] . "</small>";
                    echo "</div>";
                }
            } else {
                echo "No posts found";
            }

            ?>
        </div>

        <div class="section mt-5">
            <h2>Collaboration Opportunities</h2>
            <p>Looking for collaborators on your next big project? Connect with other innovators who share your vision.
            </p>
            <?php
            $sql = "SELECT * FROM posts WHERE category='CollaborationOpportunities' ORDER BY created_at DESC;";
            $result = mysqli_query($connection, $sql);
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='post'>";
                    echo "<h3>" . $row['title'] . "</h3>";
                    echo "<p>" . $row['content'] . "</p>";
                    echo "<small>Posted by: " . $row['username'] . "</small>";
                    echo "</div>";
                }
            } else {
                echo "No posts found";
            }

            ?>
        </div>

        <div class="section mt-5">
            <h2>Insights and Tips</h2>
            <p>Discover valuable insights and tips from experienced innovators. Learn best practices, avoid common
                pitfalls, and stay ahead in the innovation landscape.</p>
            <?php
            $sql = "SELECT * FROM posts WHERE category='InsightsandTips' ORDER BY created_at DESC;";
            $result = mysqli_query($connection, $sql);
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='post'>";
                    echo "<h3>" . $row['title'] . "</h3>";
                    echo "<p>" . $row['content'] . "</p>";
                    echo "<small>Posted by: " . $row['username'] . "</small>";
                    echo "</div>";
                }
            } else {
                echo "No posts found";
            }

            ?>
        </div>


        <div class="section mt-5">
            <h2>Skills and Qualifications</h2>
            <p>Looking for collaborators on your next big project? Connect with other innovators who share your vision.
            </p>
            <?php
            $sql = "SELECT * FROM posts WHERE category='SkillsandQualifications' ORDER BY created_at DESC;";
            $result = mysqli_query($connection, $sql);
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='post'>";
                    echo "<h3>" . $row['title'] . "</h3>";
                    echo "<p>" . $row['content'] . "</p>";
                    echo "<small>Posted by: " . $row['username'] . "</small>";
                    echo "</div>";
                }
            } else {
                echo "No posts found";
            }

            ?>
        </div>

        <div class="section mt-5">
            <h2>Personal Branding</h2>
            <p>Looking for collaborators on your next big project? Connect with other innovators who share your vision.
            </p>
            <?php
            $sql = "SELECT * FROM posts WHERE category='PersonalBranding' ORDER BY created_at DESC;";
            $result = mysqli_query($connection, $sql);
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='post'>";
                    echo "<h3>" . $row['title'] . "</h3>";
                    echo "<p>" . $row['content'] . "</p>";
                    echo "<small>Posted by: " . $row['username'] . "</small>";
                    echo "</div>";
                }
            } else {
                echo "No posts found";
            }

            ?>
        </div>

        <div class="section mt-5">
            <h2>Insights and Tips</h2>
            <p>Looking for collaborators on your next big project? Connect with other innovators who share your vision.
            </p>
            <?php
            $sql = "SELECT * FROM posts WHERE category='InsightsandTips' ORDER BY created_at DESC;";
            $result = mysqli_query($connection, $sql);
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='post'>";
                    echo "<h3>" . $row['title'] . "</h3>";
                    echo "<p>" . $row['content'] . "</p>";
                    echo "<small>Posted by: " . $row['username'] . "</small>";
                    echo "</div>";
                }
            } else {
                echo "No posts found";
            }

            ?>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>




    </div>
    </div>


    <div id="footer">
        <?php include '../footer.php' ?>
    </div>


</body>



</html