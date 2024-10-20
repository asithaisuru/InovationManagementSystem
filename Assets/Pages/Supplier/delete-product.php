<?php
require_once "../Classes/Item.php";

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

        $item = new Item($prodid, "", "", "", $username, "");
        $item->delete($connection);
        $connection->close();
    } else {
        echo "<script>window.location.href='delete-prod.php?projectdeletestatus=error';</script>";
    }
} else {
    echo "<script>window.location.href='delete-prod.php?projectdeletestatus=error1';</script>";
}
