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

// Mock data for demonstration purposes. Replace with database fetching logic.
$topics = [
    ['id' => 1, 'title' => 'First Topic'],
    ['id' => 2, 'title' => 'Second Topic']
];

?>


<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>

<body class="bg-dark text-white">
    <?php include '../Innovator/innovator-nav.php'; ?>

    <div class="container">
        
    </div>
    <h1>Forum</h1>
        <a href="add_topic.php" class="btn btn-success mb-3">Add New Topic</a>
        <div class="list-group">
            <?php foreach ($topics as $topic): ?>
            <a href="view_topic.php?id=<?php echo $topic['id']; ?>" class="list-group-item list-group-item-action">
                <?php echo htmlspecialchars($topic['title']); ?>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>


</body>

</html