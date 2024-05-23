<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- End of Bootstrap -->

    <title>IMS - Login or Signup</title>
</head>

<body class="bg-dark">
    <div class="container mt-4">
        <div class="card p-5 bg-dark border-white border-3">
            <div class="mt-2 p-3 bg-primary text-white rounded">
                <img class="card-img-top mx-auto d-block" src="./Assets/img/LogoWhite.png" alt="Logo"
                    style="width:150px;height:150px;">
                <div class="my-3">
                    <h1 class="text-center">Innovation Management System</h1>
                    <p class="text-center display-6"><small>Step into the new world</small></p>
                </div>
                <hr>
                <h3 class="text-center">Login</h3>
            </div>
            <div class="card-body">
                <form action="index.php" method="POST">
                    <div class="form-floating mb-3 mt-3">
                        <input type="text" class="form-control" id="username" placeholder="Enter Username"
                            name="username">
                        <label for="username">Username</label>
                    </div>

                    <div class="form-floating mt-3 mb-3">
                        <input type="text" class="form-control" id="password" placeholder="Enter password"
                            name="password">
                        <label for="pwd">Password</label>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-block"><Strong>Login</Strong></button>
                        <hr style="border-top: 3px solid white; width: 100%; margin-top: 5px; margin-bottom: 5px;">
                        <a href="Assets/Pages/signup.php" class="btn btn-success btn-block">Signup</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <div>
        <footer class="bg-dark text-white">
            <div class="container py-4">
                <div class="row">
                    <div class="col text-center">
                        <p>&copy;
                            <?php
                            $stYear = 2024;
                            $nowyear = date("Y");
                            if ($stYear == $nowyear) {
                                echo "$stYear";
                            } else {
                                echo "$stYear - $nowyear";
                            }
                            ?>
                            - Group 03. All rights reserved.
                        </p>
                    </div>
                </div>
        </footer>
    </div>
</body>

</html>

<?php
require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// $dbHost = $_ENV['DB_HOST'];
// $dbUser = $_ENV['DB_USER'];
// $dbPassword = $_ENV['DB_PASSWORD'];
// $dbName = $_ENV['DB_NAME'];

$connection = mysqli_connect($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $_ENV['DB_NAME']);
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

$username = isset($_POST['username']) ? $_POST['username'] : "";
$password = isset($_POST['password']) ? $_POST['password'] : "";

if (!empty($username) && !empty($password)) {
    $query = "SELECT * FROM users WHERE userName = '$username' AND pass = '$password'";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $role = $row['role'];
        if ($role == 'Innovator') {
            header("Location: Assets/Pages/Innovator/innovator-dashboard.php");
        } else if ($role == 'Supplier') {
            header("Location: Assets/Pages/Supplier/supplier-dashboard.php");
        } else if ($role == "Admin") {
            header("Location: Assets/Pages/Admin/admin-dashboard.php");
        }
    } else {
        echo '<style>#form-Bottom-Span{visibility: visible !important;}</style>';
    }
}
?>