<?php

require_once "../Classes/Administrator.php";
require_once "../dbconnection.php";

$admin = new Administrator(null, null);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prodId = $_POST['prodId'];
    $status = $_POST['status'];

    $approvalStatus = $admin->updateProdStatus($connection, $prodId, $status);
    echo $approvalStatus;
    if ($approvalStatus) {
        header("Location: ./view-all-products.php");
        // echo "<script>window.location.href='./view-all-products.php;</script>";
    } else {
        header("Location: ./error.php?msj=Error while updating the status of the Product");
        // echo "<script>window.location.href='../error.php?msj=Error while updating the status of the Product';</script>";
    }
}