<?php
include '../dbconnection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $remove_username = $_POST['remove_username'];
    // Get the username to be removed from the form data

    // Check if the user exists in the database
    $query = "SELECT * FROM users WHERE username = '$remove_username'";
    $result = mysqli_query($connection, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $role = $row['role'];
        echo $role;
        // Get the role of the user

        // Check if the user has the role of 'Admin' or 'Moderator'
        if ($role == 'Admin' || $role == 'Moderator') {
            // If the user has the role of 'Admin' or 'Moderator', delete the user from the database
            $query = "DELETE FROM users WHERE username = '$remove_username'";
            $result = mysqli_query($connection, $query);
            if ($result) {
                // If the user is successfully deleted, redirect to the user management page with a success message
                header("Location: ./user-management.php?status=userremovesuccess#remove-user");
                exit();
            } else {
                // If there is an error while deleting the user, redirect to the user management page with an error message
                header("Location: ./user-management.php?status=userremovefailed#remove-user");
                exit();
            }
        }
    } else {
        // If the user does not exist in the database, redirect to the user management page with a user not found message
        header("Location: ./user-management.php?status=userremoveusernotfound#remove-user");
        exit();
    }

} else {
    // If the request method is not POST, redirect to the user management page with a method not allowed message
    header("Location: ./user-management.php?status=userremovemethodnotpost#remove-user");
    exit();
}