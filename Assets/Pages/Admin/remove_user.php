<?php
include '../dbconnection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $remove_username = $_POST['remove_username'];
    // echo $remove_username;
    // $query = "DELETE FROM users WHERE username = '$username'";
    $query = "SELECT * FROM users WHERE username = '$remove_username'";
    $result = mysqli_query($connection, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $role = $row['role'];
        echo $role;
        if ($role == 'Admin' || $role == 'Moderator') {
            $query = "DELETE FROM users WHERE username = '$remove_username'";
            $result = mysqli_query($connection, $query);
            if ($result) {
                header("Location: ./user-management.php?status=userremovesuccess#remove-user");
                exit();
            } else {
                header("Location: ./user-management.php?status=userremovefailed#remove-user");
                exit();
            }
        }
    } else {
        header("Location: ./user-management.php?status=userremoveusernotfound#remove-user");
        exit();
    }

} else {
    header("Location: ./user-management.php?status=userremovemethodnotpost#remove-user");
    exit();
}