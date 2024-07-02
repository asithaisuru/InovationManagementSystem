<?php
require_once '../signup-process.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // $file = $_FILES["file"];
    $username = filter_var($_POST["username"],FILTER_SANITIZE_STRING);
    $firstname = filter_var($_POST["fname"],FILTER_SANITIZE_STRING);
    $lastname = filter_var($_POST["lname"],FILTER_SANITIZE_STRING);
    $password = filter_var($_POST["password"],FILTER_SANITIZE_STRING);
    $email = filter_var($_POST["email"],FILTER_SANITIZE_EMAIL);
    $repassword = filter_var($_POST["repassword"],FILTER_SANITIZE_STRING);
    $role = $_POST["role"];

    $signup = new Signup($username, $firstname, $lastname, $email, $role, $password, $repassword);
    $signup->signup($connection);
    if($signup->getSuccessStatusOfUserRegister()){
        $msg = "User added successfully.";
        echo "<script>window.location.href='./user-management.php?adduserstatus=success&msg=$msg';</script>";
        exit();
    }
    $connection->close();
}