<?php
session_start();
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
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
    <title>Document</title>
</head>

<body class="bg-dark text-white">
    <?php include 'admin-nav.php'; ?>
    <div class="container text-center">
        <h1>Admin Dashboard</h1>
        <p>This is the Admin Dashboard. You can create manage Admin profiles, projects</p>

    </div>

    <div id="footer">
        <?php include '../footer.php' ?>
    </div>
</body>

</html>