<?php

?>

<!DOCTYPE html>
<html>

<head>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- End of Bootstrap -->

    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>

    <title>Signup Form</title>

</head>

<body class="bg-dark">
    <div class="container mt-5">
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
                <form action="signup.php" method="POST">
                    <div class="form-floating mb-3 mt-3">
                        <input type="text" class="form-control" id="username" placeholder="Enter Username"
                            name="username" required>
                        <label for="username">Username</label>
                        <small class="text-secondary"><span class="text-danger">* </span>
                            <span data-bs-toggle="tooltip" data-bs-placement="bottom"
                                title="!@#$%^&*()-=_+[]{}\|;:'&quot;,.<>?/" class="text-white"><kbd>Symbols</kbd></span>
                            and
                            <span data-bs-toggle="tooltip" data-bs-placement="bottom" title=".,:;!?'()[]{}"
                                class="text-white"><kbd>Punctuation marks</kbd></span> are not allowed.
                        </small>
                    </div>

                    <div class="form-floating mb-3 mt-3">
                        <input type="text" class="form-control" id="fname" placeholder="Enter First Name" name="fname"
                            required>
                        <label for="fname">First Name</label>
                    </div>

                    <div class="form-floating mb-3 mt-3">
                        <input type="text" class="form-control" id="lname" placeholder="Enter Last Name" name="lname"
                            required>
                        <label for="lname">Last Name</label>
                    </div>

                    <div class="form-floating mb-3 mt-3">
                        <input type="text" class="form-control" id="email" placeholder="Enter Email" name="email"
                            required>
                        <label for="email">Email</label>
                    </div>

                    <div class="form-floating mb-3 mt-3">
                        <select class="form-select mt-3" required name="role" id="role">
                            <option disabled selected></option>
                            <option value="Innovator">Innovator</option>
                            <option value="Supplier">Supplier</option>
                            <option value="Buyer">Buyer</option>
                        </select>
                        <label for="role">Select Role</label>
                    </div>

                    <div class="form-floating mt-3 mb-3 position-relative">
                        <input type="password" class="form-control" id="password" placeholder="Enter password"
                            name="password" required>
                        <label for="password">Password</label>
                        <button type="button"
                            class="btn btn-outline-secondary position-absolute top-50 end-0 translate-middle-y border-0"
                            id="togglePassword1"
                            style="border-top-left-radius: 0; border-bottom-left-radius: 0;height:58px">
                            <i class="fa fa-eye" id="toggleIcon1"></i>
                        </button>
                    </div>

                    <div class="form-floating mt-3 mb-3 position-relative">
                        <input type="password" class="form-control" id="repassword" placeholder="Re Enter password"
                            name="repassword" required>
                        <label for="repassword">Repeat Password</label>
                        <button type="button"
                            class="btn btn-outline-secondary position-absolute top-50 end-0 translate-middle-y border-0"
                            id="togglePassword2"
                            style="border-top-left-radius: 0; border-bottom-left-radius: 0;height:58px;">
                            <i class="fa fa-eye" id="toggleIcon2"></i>
                        </button>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success btn-block"><Strong>Create Account</Strong></button>
                        <hr style="border-top: 3px solid white; width: 100%; margin-top: 5px; margin-bottom: 5px;">
                        <span class="text-center text-white">Already have an Account ?</span>
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

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
    <script>
        document.getElementById('togglePassword1').addEventListener('click', function () {
            const passwordField = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon1');
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            if (toggleIcon.classList.contains('fa-eye-slash')) {
                toggleIcon.classList.add('fa-eye');
            } else {
                toggleIcon.classList.add('fa-eye-slash');
            }
        });

        document.getElementById('togglePassword2').addEventListener('click', function () {
            const passwordField = document.getElementById('repassword');
            const toggleIcon = document.getElementById('toggleIcon2');
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
include './dbconnection.php';
include './password.php';
require_once './signup-process.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // $file = $_FILES["file"];
    $username = $_POST["username"];
    $firstname = $_POST["fname"];
    $lastname = $_POST["lname"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    $repassword = $_POST["repassword"];
    $role = $_POST["role"];

    $signup = new Signup($username, $firstname, $lastname, $email, $role, $password, $repassword);
    $signup->signup($connection);
    if ($signup->getSuccessStatusOfUserRegister()){
        echo '<script>
            setTimeout(function(){
                alert("User Register Successfull. Redirecting to index...");
                window.location.href = "../../index.php";
            }, 1000);
        </script>';
    }else{
        echo '<script>alert("User Register Failed.");</script>';
    }
    $connection->close();
}
?>