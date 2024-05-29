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
    <title>IMS - Dashboard</title>
</head>

<body class="bg-dark text-white">
    <?php include 'admin-nav.php'; ?>

    <?php if ($_SESSION['role'] == "Admin"): ?>
        <div class="container text-center">
            <h1>Admin Dashboard</h1>
            <p>This is the Admin Dashboard. You can create manage Admin profiles, projects</p>
        </div>

    <?php elseif ($_SESSION['role'] == "Moderator"): ?>
        <div class="container text-center">
            <h1>Moderator Dashboard</h1>
            <p>This is the Moderator Dashboard. You can manage projects and solve problems of coustomers.</p>
        </div>
    <?php endif; ?>

    <div id="footer">
        <?php include '../footer.php' ?>
    </div>
</body>

</html>