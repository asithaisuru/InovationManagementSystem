<?php
session_start();

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $role = $_SESSION['role'];
    if ($role != 'Supplier') {
        echo "<script>window.location.href='../../../sign-in.php';</script>";
        exit();
    }
} else {
    echo "<script>window.location.href='../../../sign-in.php';</script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include '../dbconnection.php';

    if (isset($connection)) {
        $prodid = ($_POST['prodid']);

        // Prepare the SQL statement to prevent SQL injection
        $sql = "DELETE FROM items WHERE prodId = ? AND userName = ?";
        if ($stmt = $connection->prepare($sql)) {
            $stmt->bind_param('is', $prodid, $username);

            if ($stmt->execute()) {
                echo "<script>window.location.href='delete-prod.php?projectdeletestatus=success';</script>";
            } else {
                echo "<script>window.location.href='delete-prod.php?projectdeletestatus=error';</script>";
            }
            $stmt->close();
        } else {
            echo "<script>window.location.href='delete-prod.php?projectdeletestatus=error';</script>";
        }
        $connection->close();
    } else {
        echo "<script>window.location.href='delete-prod.php?projectdeletestatus=error';</script>";
    }
} else {
    echo "<script>window.location.href='delete-prod.php?projectdeletestatus=error1';</script>";
}
