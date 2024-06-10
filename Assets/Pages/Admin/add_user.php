<?php
require_once '../signup-process.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // $file = $_FILES["file"];
    $username = $_POST["username"];
    $firstname = $_POST["fname"];
    $lastname = $_POST["lname"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    $repassword = $_POST["repassword"];
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