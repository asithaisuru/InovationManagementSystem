<?php
<<<<<<< HEAD
require '../db.php';

$result = $conn->query("SELECT id, title, content FROM topics ORDER BY created_at DESC");
$topics = $result->fetch_all(MYSQLI_ASSOC);
=======
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

>>>>>>> 34e24a154fcbef028970417a59a139428ddc79f0
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum</title>
</head>
<<<<<<< HEAD
<body>
    <div class="container mt-5">
        <h1>Forum</h1>
        <a href="add_topic.php" class="btn btn-success mb-3">Add New Topic</a>
        <div class="row">
            <?php foreach ($topics as $topic): ?>
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($topic['title']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars(substr($topic['content'], 0, 100)); ?>...</p>
                        <a href="view_topic.php?id=<?php echo $topic['id']; ?>" class="btn btn-primary">Read More</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
=======

<body class="bg-dark text-white">
    <?php include '../Innovator/innovator-nav.php'; ?>

    <div class="container">
        
    </div>


>>>>>>> 34e24a154fcbef028970417a59a139428ddc79f0
</body>
</html>
