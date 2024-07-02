<?php
// Start the session
session_start();

// Include the autoloader for Composer packages
require_once __DIR__ . '/vendor/autoload.php';

// Load the environment variables from the .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Establish a connection to the database using the environment variables
$connection = mysqli_connect($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $_ENV['DB_NAME']);
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

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

<body class="bg-dark text-white">
    <?php
    // Display the IMS logo and title
    ?>
    <div class="container mt-5">
        <div class="card p-4 bg-dark border-white border-3">
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

                    <div class="form-floating mt-3 mb-3 position-relative">
                        <input type="password" class="form-control" id="password" placeholder="Enter password"
                            name="password">
                        <label for="password">Password</label>
                        <button type="button"
                            class="btn btn-outline-secondary position-absolute top-50 end-0 translate-middle-y border-0"
                            id="togglePassword"
                            style="border-top-left-radius: 0; border-bottom-left-radius: 0;height:58px;">
                            <i class="fa fa-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-block"><Strong>Login</Strong></button>
                        <hr style="border-top: 3px solid white; width: 100%; margin-top: 5px; margin-bottom: 5px;">
                        <span class="text-center text-white">Don't have an Account ?</span>
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
                            // Display the copyright information
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

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordField = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            if (toggleIcon.classList.contains('fa-eye-slash')) {
                toggleIcon.classList.add('fa-eye');
            } else {
                toggleIcon.classList.add('fa-eye-slash');
            }
        });
    </script>
</body>

</html>

<?php

// Include the password.php file
include './Assets/Pages/password.php';

class User
{
    private $username;
    private $password;
    private $role;

    function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    function makeuseractive()
    {
        require_once './Assets/Pages/dbconnection.php';
        $username = $_SESSION['username'];
        $sql = "UPDATE users SET active = 1 WHERE userName = '$username'";
        $result = mysqli_query($connection, $sql);
        if (!$result) {
            echo "unable to Active user";
        }
    }

    function getPasswordfromDB($connection)
    {
        $username = $this->username;
        $query = "SELECT pass,role FROM users WHERE userName = ?";
        $statement = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($statement, "s", $username);
        mysqli_stmt_execute($statement);
        $result = mysqli_stmt_get_result($statement);

        return $result;
    }

    function setSession()
    {
        $_SESSION['username'] = $this->username;
        $_SESSION['role'] = $this->role;
        $_SESSION['pass'] = $this->password;
    }

    function verifyPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }

    function redirecttopages()
    {
        if ($this->role == 'Innovator') {
            // Redirect to the Innovator dashboard
            $this->makeuseractive();
            echo "<script>window.location.href='Assets/Pages/Innovator/innovator-dashboard.php';</script>";
        } else if ($this->role == 'Supplier') {
            // Redirect to the Supplier dashboard
            $this->makeuseractive();
            echo "<script>window.location.href='Assets/Pages/Supplier/supplier-dashboard.php';</script>";
        } else if ($this->role == "Admin" || $this->role == "Moderator") {
            // Redirect to the Admin dashboard
            $this->makeuseractive();
            echo "<script>window.location.href='Assets/Pages/Admin/admin-dashboard.php';</script>";
        
        } else if ($this->role == "Buyer") {
            // Redirect to the forum
            $this->makeuseractive();
            echo "<script>window.location.href='Assets/Pages/Forum/forum.php';</script>";
        }

    }

    function login($connection)
    {
        $result = $this->getPasswordfromDB($connection);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $this->role = $row['role'];
            $hash = $row['pass'];
            if ($this->verifyPassword($this->password, $hash)) {
                $this->setSession();
                $this->redirecttopages();
            } else {
                // Display an error message for invalid username or password
                echo "<script>alert('Invalid Username or Password')</script>;";
            }
        }
    }
}

if (isset($_POST['username']) && isset($_POST['password'])) {
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $user = new User($username, $password);
        $user->login($connection);
    } else {
        echo "<script>alert('Invalid Username or Password')</script>;";
    }
}
?>