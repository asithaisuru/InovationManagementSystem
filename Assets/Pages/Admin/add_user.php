<?php
include '../dbconnection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = $_POST["username"];
    $firstname = $_POST["fname"];
    $lastname = $_POST["lname"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    $repassword = $_POST["repassword"];
    $role = $_POST["role"];

    // Check if passwords match
    if ($password != $repassword) {
        $em = "Passwords do not match. Please re-enter passwords.";
        header("Location: ./user-management.php?adduserstatus=error&msg=$em");
        exit();
    }
    
    // Check if username is valid
    if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        $em = "Invalid username format. Please enter a valid username.";
        header("Location: ./user-management.php?adduserstatus=error&msg=$em");
        exit();
    }

    // Check if email is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $em = "Invalid email format. Please enter a valid email address.";
        header("Location: ./user-management.php?adduserstatus=error&msg=$em");
        exit();
    }

    // Check if email already exists
    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($connection, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $em = "Email already exists. Try a different email or login.";
        header("Location: ./user-management.php?adduserstatus=error&msg=$em");
        exit();
    }

    // Check if username already exists
    $query = "SELECT * FROM users WHERE userName='$username'";
    $result = mysqli_query($connection, $query);
    if (mysqli_num_rows($result) > 0) {
        $em = "Username already exists. Try a different username.";
        header("Location: ./user-management.php?adduserstatus=error&msg=$em");
        exit();
    } else {
        // Include password hashing function
        include '../password.php';
        $hashpw = hashPassword($password);
        
        // Insert user data into database
        $sql = "INSERT INTO users (userName, fname, lname, email, role, pass) VALUES ('$username', '$firstname', '$lastname', '$email', '$role', '$hashpw')";
        if ($connection->query($sql) === TRUE) {
            $em = "User registered successfully.";
            header("Location: ./user-management.php?adduserstatus=success&msg=$em");
        } else {
            $em = "User registration failed.";
            header("Location: ./user-management.php?adduserstatus=error&msg=$em");
        }
    }

    $connection->close();
}
