<?php
session_start();
if (isset($_SESSION['username']) || isset($_SESSION['role'])) {
    $username = $_SESSION['username'];
    $role = $_SESSION['role'];
    if ($role != 'Buyer') {
        echo "<script>window.location.href='../../../sign-in.php';</script>";
        exit();
    }
} else {
    echo "<script>window.location.href='../../../sign-in.php';</script>";
    exit();
}

include '../dbconnection.php';

function dbconnection() {
    $conn = mysqli_connect("localhost", "root", "", "ims"); 
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    return $conn;
}

$conn = dbconnection();

// Fetch posts added to interests
$query = "
    SELECT posts.postid, posts.title, posts.content, posts.date 
    FROM posts 
    INNER JOIN Buyer_Interests ON posts.postid = Buyer_Interests.post_id 
    WHERE Buyer_Interests.buyer_username = '$username' 
    ORDER BY posts.date DESC";
$result = mysqli_query($conn, $query);
$interests_posts = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $interests_posts[] = $row;
    }
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Interests</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Start of Tawk.to Script -->
    <script type="text/javascript">
    var Tawk_API = Tawk_API || {},
        Tawk_LoadStart = new Date();
    (function() {
        var s1 = document.createElement("script"),
            s0 = document.getElementsByTagName("script")[0];
        s1.async = true;
        s1.src = 'https://embed.tawk.to/664344a19a809f19fb30bb2f/1htrc868i';
        s1.charset = 'UTF-8';
        s1.setAttribute('crossorigin', '*');
        s0.parentNode.insertBefore(s1, s0);
    })();
    </script>
    <!-- End of Tawk.to Script -->
</head>

<body class="bg-dark text-white">

    <?php include 'buyer-nav.php'; ?>
    
    <div class="container mt-5">
        <h1 class="text-center mb-4">My Interests</h1>
        <div class="d-flex flex-column align-items-center">
            <div class="card bg-dark text-white text-center mt-4 w-50">
                <div class="card-body">
                    <?php if (!empty($interests_posts)) : ?>
                        <?php foreach ($interests_posts as $post) : ?>
                            <div class="mb-3">
                                <h3><?php echo htmlspecialchars($post['title']); ?></h3>
                                <p><?php echo htmlspecialchars($post['content']); ?></p>
                                <small><?php echo htmlspecialchars($post['date']); ?></small>
                            </div>
                            <hr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p>No posts in your interests.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php include '../footer.php'; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>