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
        <p class="text-center">A space for sharing success stories, seeking collaborators, and exchanging insights into the innovation process.</p>
        
        <!-- Form to submit a new post -->
        <div class="card bg-light text-dark mb-4">
            <div class="card-header">
                <h2>Share Your Story or Find Collaborators</h2>
            </div>
            <div class="card-body">
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="post_title">Title</label>
                        <input type="text" name="post_title" id="post_title" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="post_content">Content</label>
                        <textarea name="post_content" id="post_content" class="form-control" rows="5" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="post_category">Category</label> </br>
                        <select name="post_category" id="post_category" class="form-control" required>
                            <option value="Success Stories">Success Stories</option>
                            <option value="Collaboration Opportunities">Collaboration Opportunities</option>
                            <option value="Insights and Tips">Insights and Tips</option>
                            <option value="Insights and Tips">Skills and Qualifications</option>
                            <option value="Insights and Tips">Personal Branding </option>
                            <option value="Insights and Tips">Insights and Tips</option>
                        </select>
                    </div> <br>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>

        <!-- Display Posts -->
        <div class="section mt-5">
            <h2>Success Stories</h2>
            <p>Read about the latest success stories from our community. Be inspired by the journeys and achievements of fellow innovators.</p>
            <?php
            $result = mysqli_query($conn, "SELECT * FROM posts WHERE category='Success Stories' ORDER BY created_at DESC");
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='post'>";
                echo "<h3>" . $row['title'] . "</h3>";
                echo "<p>" . $row['content'] . "</p>";
                echo "<small>Posted by: " . $row['username'] . "</small>";
                echo "</div>";
            }
            ?>
        </div>

        <div class="section mt-5">
            <h2>Collaboration Opportunities</h2>
            <p>Looking for collaborators on your next big project? Connect with other innovators who share your vision.</p>
            <?php
            $result = mysqli_query($conn, "SELECT * FROM posts WHERE category='Collaboration Opportunities' ORDER BY created_at DESC");
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='post'>";
                echo "<h3>" . $row['title'] . "</h3>";
                echo "<p>" . $row['content'] . "</p>";
                echo "<small>Posted by: " . $row['username'] . "</small>";
                echo "</div>";
            }
            ?>
        </div>

        <div class="section mt-5">
            <h2>Insights and Tips</h2>
            <p>Discover valuable insights and tips from experienced innovators. Learn best practices, avoid common pitfalls, and stay ahead in the innovation landscape.</p>
            <?php
            $result = mysqli_query($conn, "SELECT * FROM posts WHERE category='Insights and Tips' ORDER BY created_at DESC");
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='post'>";
                echo "<h3>" . $row['title'] . "</h3>";
                echo "<p>" . $row['content'] . "</p>";
                echo "<small>Posted by: " . $row['username'] . "</small>";
                echo "</div>";
            }
            ?>
        </div>
    </div>

    <div class="section mt-5">
            <h2>Skills and Qualifications</h2>
            <p>Looking for collaborators on your next big project? Connect with other innovators who share your vision.</p>
            <?php
            $result = mysqli_query($conn, "SELECT * FROM posts WHERE category='Skills and Qualifications' ORDER BY created_at DESC");
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='post'>";
                echo "<h3>" . $row['title'] . "</h3>";
                echo "<p>" . $row['content'] . "</p>";
                echo "<small>Posted by: " . $row['username'] . "</small>";
                echo "</div>";
            }
            ?>
        </div>

        <div class="section mt-5">
            <h2>Personal Branding</h2>
            <p>Looking for collaborators on your next big project? Connect with other innovators who share your vision.</p>
            <?php
            $result = mysqli_query($conn, "SELECT * FROM posts WHERE category='Personal Branding' ORDER BY created_at DESC");
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='post'>";
                echo "<h3>" . $row['title'] . "</h3>";
                echo "<p>" . $row['content'] . "</p>";
                echo "<small>Posted by: " . $row['username'] . "</small>";
                echo "</div>";
            }
            ?>
        </div>

        <div class="section mt-5">
            <h2>Insights and Tips</h2>
            <p>Looking for collaborators on your next big project? Connect with other innovators who share your vision.</p>
            <?php
            $result = mysqli_query($conn, "SELECT * FROM posts WHERE category='Insights and Tips' ORDER BY created_at DESC");
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='post'>";
                echo "<h3>" . $row['title'] . "</h3>";
                echo "<p>" . $row['content'] . "</p>";
                echo "<small>Posted by: " . $row['username'] . "</small>";
                echo "</div>";
            }
            ?>
        </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
 

    
       
    </div>

    
    <div id="footer">
        <?php include '../footer.php' ?>
    </div>


</body>



</html