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
    <style>
    #backToTopBtn {
        display: none; /* Initially hide the button */
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 100; /* Ensure the button is above other elements */
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
                    $categories = array(
                        'SuccessStories' => 'Success Stories',
                        'CollaborationOpportunities' => 'Collaboration Opportunities',
                        'InsightsandTips' => 'Insights and Tips',
                        'SkillsandQualifications' => 'Skills and Qualifications',
                        'PersonalBranding' => 'Personal Branding'
                    );
                    foreach ($categories as $value => $label) {
                        echo "<option value='$value'>$label</option>";
                    }
                    ?>
                </select> </br>
                <button class="btn btn-primary" type="submit">Search Posts</button>
                </form>
            </div>
            

        <!-- Display Posts -->
        <?php
        $sql = "SELECT * FROM posts";
        if(isset($_GET['post_category']) && $_GET['post_category'] != 'all') {
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
                echo "</div>";
            }
        } else {
            echo "No posts found";
        }
        ?>
        
        
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </div>
    </div>
    <div class="position-fixed bottom-0 end-0 m-3">
    <!-- Back to Top Button -->
     <button id="backToTopBtn" class="btn btn-success rounded-circle p-3" type="submit">Top</button>
     <!-- Custom JS -->
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

        // Smooth scroll to top when the button is clicked
        document.getElementById('backToTopBtn').addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
        
    </script>
    
    </div>
    
    <div id="footer">
        <?php include '../footer.php' ?>
    </div>


</body>

</html>