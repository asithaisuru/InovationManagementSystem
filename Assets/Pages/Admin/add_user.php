<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../../');
$dotenv->load();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $firstname = $_POST["fname"];
    $lastname = $_POST["lname"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    $repassword = $_POST["repassword"];

    if ($password != $repassword) {
        echo '<script type="text/javascript">
                window.onload = function () { alert("Passwords do not match. Please re-enter passwords."); }
            </script>';
        exit();
    }
    if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        echo '<script type="text/javascript">
                window.onload = function () { alert("Invalid username format. Please enter a valid username."); }
            </script>';
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<script type="text/javascript">
                window.onload = function () { alert("Invalid email format. Please enter a valid email address."); }
            </script>';
        exit();
    }

    $connection = mysqli_connect($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $_ENV['DB_NAME']);
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $query = "SELECT * FROM users WHERE userName='$username'";
    $result = mysqli_query($connection, $query);
    if (mysqli_num_rows($result) > 0) {
        echo '<script type="text/javascript">
                window.onload = function () { alert("Username already exists. Try a different username."); }
            </script>';
        exit();
    } else {
        $sql = "INSERT INTO users (userName, fname, lname, email, role, pass) VALUES ('$username', '$firstname', '$lastname', '$email', 'Admin', '$password')";
        if ($connection->query($sql) === TRUE) {
            echo '<script type="text/javascript">            
                    window.onload = function () { alert("User registered successfully. Please Login. Redirect to Admin Dashdoard page..."); };
                    
                        window.location.href = "./admin-dashboard.php?status=success";
                    
                </script>';
        } else {
            // echo "Error: " . $sql . "<br>" . $connection->error;
            $error = $connection->error;
            echo '<script> window.location.href = "../error.php?error='.$error.'"; </script>';
            
        }
    }

    $connection->close();
}
?>