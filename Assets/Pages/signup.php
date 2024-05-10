<!DOCTYPE html>
<html>

<head>
    <title>Signup Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('https://images.unsplash.com/photo-1551793611-5e15858c0b01?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');
            background-repeat: no-repeat;
            background-size: cover;
        }

        .container {
            margin-top: 50px;
        }

        input[type="text"],
        input[type="password"] {
            background-color: #f2f2f2;
        }

        .container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Signup Form</h2>
        <form method="POST" action="signup.php">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="firstname">First Name:</label>
                <input type="text" class="form-control" id="firstname" name="firstname" required>
            </div>
            <div class="form-group">
                <label for="lastname">Last Name:</label>
                <input type="text" class="form-control" id="lastname" name="lastname" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <div style="margin-top:10px;">
                <p>Already have an account? <a href="../../index.php">Login</a></p>
            </div>

        </form>
    </div>
</body>

</html>

<?php
require_once __DIR__ . '/../../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
$dotenv->load();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $password = $_POST["password"];
    $email = $_POST["email"];

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
        $sql = "INSERT INTO users (userName, fname, lname, email, pass) VALUES ('$username', '$firstname', '$lastname', '$email', '$password')";
        if ($connection->query($sql) === TRUE) {
            echo '<script type="text/javascript">
                window.onload = function () { alert("User registerd sucessfully. Please Login."); }
            </script>';
        } else {
            echo "Error: " . $sql . "<br>" . $connection->error;
        }
    }

    $connection->close();
}
?>