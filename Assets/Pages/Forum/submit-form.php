<?php
session_start();
// Check if the user is logged the required role
if (isset($_SESSION['username']) || isset($_SESSION['role'])) {
    $username = $_SESSION['username'];
    $role = $_SESSION['role'];
    // Redirect not an Innovator
    if ($role != 'Innovator' && $role != 'Supplier') {
        echo "<script>window.location.href='../../../index.php';</script>";
        exit();
    }
} else {
    // Redirect to the login page if the user is not logged in
    // header("Location: ../../../index.php");
    echo "<script>window.location.href='../../../index.php';</script>";
    exit();
}

// Include db
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
    <!-- Include Innovator nav-->
    <?php include '../Innovator/innovator-nav.php'; ?>

    <div class="container">

        <!--Sub Forum  -->
        <h1 class="text-center">Welcome to the Innovator Forum</h1>
        <p class="text-center">A space for sharing success stories, seeking collaborators, and exchanging insights into
            the innovation process.</p>

        <!-- Form to submit a new post -->
        <div class="card bg-light text-white bg-dark mb-4 border-3 border-white">
            <div class="card-body">
                <h2 class="text-center mb-3">Share Your Story or Find Collaborators</h2>
                <form action="submit-form.php" method="POST">
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
                            <option value="SkillsandQualifications">Skills and Qualifications</option>
                            <option value="PersonalBranding">Personal Branding </option>
                        </select>
                    </div> <br>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>

        </div>
        <div>
            <div>
                <!-- Back to Forum button -->
                <a href="./forum.php" class="btn btn-success">Back to Forum</a>
            </div>
        </div>


        <!-- footer -->
        <div id="footer">
            <?php include '../footer.php' ?>
        </div>


</body>



</html>

<?php
// Handle form submission
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post_title = $_POST['post_title'];
    $post_content = $_POST['post_content'];
    $post_category = $_POST['post_category'];

    // Insert the new post into the database
    $sql = "INSERT INTO posts (title, content, category, userName) VALUES ('$post_title', '$post_content', '$post_category', '$username');";
    $result = mysqli_query($connection, $sql);
    
    // Show an alert submission was successful
    if ($result) {
        echo "<script>alert('Post submitted successfully');</script>";
    } else {
        echo "<script>alert('Error submitting post');</script>";
    }
}
?>