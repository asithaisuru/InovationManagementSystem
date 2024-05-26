<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../../');
$dotenv->load();

// Database connection
$connection = mysqli_connect($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $_ENV['DB_NAME']);
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

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
        if ($role == 'Admin') {
            $query = "DELETE FROM users WHERE username = '$remove_username'";
            $result = mysqli_query($connection, $query);
            if ($result) {
                header("Location: ./admin-dashboard.php?status=userremovesuccess#remove-user");
                exit();
            } else {
                header("Location: ./admin-dashboard.php?status=userremovefailed#remove-user");
                exit();
            }
        }
    } else {
        header("Location: ./admin-dashboard.php?status=userremoveusernotfound#remove-user");
        exit();
    }

} else {
    header("Location: ./admin-dashboard.php?status=userremovemethodnotpost#remove-user");
    exit();
}