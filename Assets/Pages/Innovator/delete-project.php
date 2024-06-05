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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IMS - Delete Project</title>
</head>
<body class="bg-dark text-white">
    <?php include 'innovator-nav.php'; ?>

    <div class="container">
        <h2 class="text-center">Delete Project</h2>
        <div class="card mt-4 border-white border-3 bg-dark text-white">
            <div class="card-body">
                
                
            </div>
        </div>
    </div>
    
</body>
</html>