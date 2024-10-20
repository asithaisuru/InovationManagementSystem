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


// Fetch the three most recent posts
$query = "SELECT postid, title, content, date FROM posts ORDER BY date DESC LIMIT 3";
$result = mysqli_query($connection, $query);
$recent_posts = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $recent_posts[] = $row;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_interests'])) {
    $post_id = $_POST['post_id'];
    $buyer_username = $_SESSION['username'];

    $query = "INSERT INTO Buyer_Interests (buyer_username, post_id) VALUES ('$buyer_username', $post_id)";
    if (mysqli_query($connection, $query)) {
        echo "<script>alert('Post added to your interests!');</script>";
    } else {
        echo "<script>alert('Failed to add post to your interests.');</script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buyer - Dashboard</title>
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
        <h1 class="text-center mb-4">Welcome to Buyer Dashboard, <?php echo htmlspecialchars($username); ?>!</h1>
        <div class="d-flex flex-column align-items-center">
        <a href="my-interests.php" class="btn btn-primary mt-3">My Interests</a>
            <h1 class="card-title">Recent Posts</h1>

            <div class="card bg-dark text-white text-center mt-4 w-50">
                <div class="card-body">
                    <?php if (!empty($recent_posts)) : ?>
                        <?php foreach ($recent_posts as $post) : ?>
                            <div class="mb-3">
                                <h3><?php echo htmlspecialchars($post['title']); ?></h3>
                                <p><?php echo htmlspecialchars($post['content']); ?></p>
                                <small><?php echo htmlspecialchars($post['date']); ?></small>
                            </div>
                            <hr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p>No recent posts available.</p>
                    <?php endif; ?>
                    <div class="mt-4">
                                <a href="../Forum/forum.php" class="btn btn-secondary">See More</a>
                    </div>
                </div>
            </div>
        </div>

        <?php include '../footer.php'; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
</body>

</html>