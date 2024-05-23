<!DOCTYPE html>
<html>

<head>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- End of Bootstrap -->

    <title>Signup Form</title>

</head>

<body class="bg-dark">
    <div class="container mt-4">
        <div class="card p-5 bg-dark border-white border-3">
            <div class="mt-2 p-3 bg-primary text-white rounded">
                <img class="card-img-top mx-auto d-block" src="../img/LogoWhite.png" alt="Logo"
                    style="width:150px;height:150px;">
                <div class="my-3">
                    <h1 class="text-center">Innovation Management System</h1>
                    <p class="text-center display-6"><small>Step into the new world</small></p>
                    <hr>
                    <h3 class="text-center">Signup</h3>
                </div>
            </div>
            <div class="card-body">
                <form action="index.php" method="POST">
                    <div class="form-floating mb-3 mt-3">
                        <input type="text" class="form-control" id="username" placeholder="Enter Username"
                            name="username">
                        <label for="username">Username</label>
                    </div>

                    <div class="form-floating mb-3 mt-3">
                        <input type="text" class="form-control" id="fname" placeholder="Enter First Name" name="fname">
                        <label for="fname">First Name</label>
                    </div>

                    <div class="form-floating mb-3 mt-3">
                        <input type="text" class="form-control" id="lname" placeholder="Enter Last Name" name="lname">
                        <label for="lname">Last Name</label>
                    </div>

                    <div class="form-floating mb-3 mt-3">
                        <input type="text" class="form-control" id="email" placeholder="Enter Email" name="email">
                        <label for="email">Email</label>
                    </div>

                    <div class="form-floating mb-3 mt-3">                        
                        <select class="form-select mt-3">
                            <option disabled selected></option>
                            <option>Innovator</option>
                            <option>Supplier</option>
                            <option>Lawyer</option>
                            <option>Marketing Manager</option>
                        </select>
                        <label for="email">Select Role</label>
                    </div>

                    <div class="form-floating mt-3 mb-3">
                        <input type="password" class="form-control" id="password" placeholder="Enter password"
                            name="password">
                        <label for="pwd">Password</label>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success btn-block"><Strong>Create Account</Strong></button>
                        <hr style="border-top: 3px solid white; width: 100%; margin-top: 5px; margin-bottom: 5px;">
                        <a href="../../index.php" class="btn btn-primary btn-block">Login</a>
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
require_once __DIR__ . '/../../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
$dotenv->load();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $file = $_FILES["file"];
    $username = $_POST["username"];
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<script type="text/javascript">
                window.onload = function () { alert("Invalid email format. Please enter a valid email address."); }
            </script>';
        exit();
    }
    $role = $_POST["role"];

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
        $sql = "INSERT INTO users (userName, fname, lname, email, role, pass) VALUES ('$username', '$firstname', '$lastname', '$email', '$role', '$password')";
        if ($connection->query($sql) === TRUE) {
            echo '<script type="text/javascript">            
                    window.onload = function () { alert("User registered successfully. Please Login. Redirect to login page in 5 seconds..."); };
                    setTimeout(function() {
                        window.location.href = "../../index.php";
                    }, 5000);
                </script>';
        } else {
            echo "Error: " . $sql . "<br>" . $connection->error;
        }
    }

    $connection->close();
}
?>