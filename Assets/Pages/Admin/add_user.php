<?php
include '../dbconnection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $firstname = $_POST["fname"];
    $lastname = $_POST["lname"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    $repassword = $_POST["repassword"];
    $role = $_POST["role"];

    if ($password != $repassword) {
        $em = "Passwords do not match. Please re-enter passwords.";
        header("Location: ./user-management.php?adduserstatus=error&msg=$em");
        // echo '<script type="text/javascript">
        //         window.onload = function () { alert("Passwords do not match. Please re-enter passwords."); }
        //     </script>';
        exit();
    }
    if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        $em = "Invalid username format. Please enter a valid username.";
        header("Location: ./user-management.php?adduserstatus=error&msg=$em");
        // echo '<script type="text/javascript">
        //         window.onload = function () { alert("Invalid username format. Please enter a valid username."); }
        //     </script>';
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $em = "Invalid email format. Please enter a valid email address.";
        header("Location: ./user-management.php?adduserstatus=error&msg=$em");
        // echo '<script type="text/javascript">
        //         window.onload = function () { alert("Invalid email format. Please enter a valid email address."); }
        //     </script>';
        exit();
    }

    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($connection, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $em = "Email already exists. Try a different email or login.";
        header("Location: ./user-management.php?adduserstatus=error&msg=$em");
        // echo '<script type="text/javascript">
        //             window.onload = function () { alert("Email already exists. Try a different email or login."); }
        //         </script>';
        exit();
    }

    $query = "SELECT * FROM users WHERE userName='$username'";
    $result = mysqli_query($connection, $query);
    if (mysqli_num_rows($result) > 0) {
        $em = "Username already exists. Try a different username.";
        header("Location: ./user-management.php?adduserstatus=error&msg=$em");
        // echo '<script type="text/javascript">
        //         window.onload = function () { alert("Username already exists. Try a different username."); }
        //     </script>';
        exit();
    } else {
        include '../password.php';
        $hashpw = hashPassword($password);
        $sql = "INSERT INTO users (userName, fname, lname, email, role, pass) VALUES ('$username', '$firstname', '$lastname', '$email', '$role', '$hashpw')";
        if ($connection->query($sql) === TRUE) {
            $em = "User registered successfully.";
            header("Location: ./user-management.php?adduserstatus=success&msg=$em");
            // echo '<script type="text/javascript">            
            //         window.onload = function () { alert("User registered successfully. Redirect to Admin Dashdoard page..."); };

            //             window.location.href = "./user-management.php?status=success#add-user";

            //     </script>';
        } else {
            // echo "Error: " . $sql . "<br>" . $connection->error;
            // $error = $connection->error;
            $em = "User registration failed.";
            header("Location: ./user-management.php?adduserstatus=success&msg=$em");
            // echo '<script> window.location.href = "../error.php?error=' . $error . '#add-user"; </script>';

        }
    }

    $connection->close();
}
?>