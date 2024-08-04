<?php
session_start();
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    // If session username is not set, redirect to index.php
    echo "<script>window.location.href='../../../index.php';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IMS - Reset Password</title>
</head>

<body class="bg-dark text-white">
    <?php
    if ($_SESSION['role'] == "Admin") {
        // Include admin navigation if user role is Admin
        include './admin-nav.php';
    } else if ($_SESSION['role'] == "Innovator") {
        // Include innovator navigation if user role is Innovator
        include '../Innovator/innovator-nav.php';
    }else if ($_SESSION['role'] == "Buyer") {
        // Include innovator navigation if user role is Innovator
        include '../Buyer/buyer-nav.php';
    }
    ?>

    <div class="container">
        <div class="card bg-dark text-white border-3 border-white">
            <div class="card-header">
                <h1>Reset Password</h1>
            </div>
            <div class="card-body">
                <div class="form-floating mb-3 mt-3">
                    <input type="text" class="form-control" id="username" placeholder="Username" name="username"
                        disabled value="<?php echo $username ?>">
                    <label for="username" class="text-dark">Username</label>
                </div>
                <form action="resetpassword.php" method="POST">
                    <div class="form-floating mb-3 mt-3 position-relative">
                        <input type="password" class="form-control" id="oldpassword" placeholder="Enter Old Password"
                            name="oldpassword" required>
                        <label for="oldpassword" class="text-dark">Old Password</label>
                        <button type="button"
                            class="btn btn-outline-secondary position-absolute top-50 end-0 translate-middle-y border-0"
                            id="togglePassword3"
                            style="border-top-left-radius: 0; border-bottom-left-radius: 0;height:58px;">
                            <i class="fa fa-eye" id="toggleIcon3"></i>
                        </button>
                    </div>
                    <div class="form-floating mb-3 mt-3 position-relative">
                        <input type="password" class="form-control" id="newpassword" placeholder="Enter New Password"
                            name="newpassword" required>
                        <label for="newpassword" class="text-dark">New Password</label>
                        <button type="button"
                            class="btn btn-outline-secondary position-absolute top-50 end-0 translate-middle-y border-0"
                            id="togglePassword1"
                            style="border-top-left-radius: 0; border-bottom-left-radius: 0;height:58px">
                            <i class="fa fa-eye" id="toggleIcon1"></i>
                        </button>
                    </div>
                    <div class="form-floating mb-3 mt-3 position-relative">
                        <input type="password" class="form-control" id="confirmpassword"
                            placeholder="Confirm New Password" name="confirmpassword" required>
                        <label for="confirmpassword" class="text-dark">Confirm New Password</label>
                        <button type="button"
                            class="btn btn-outline-secondary position-absolute top-50 end-0 translate-middle-y border-0"
                            id="togglePassword2"
                            style="border-top-left-radius: 0; border-bottom-left-radius: 0;height:58px;">
                            <i class="fa fa-eye" id="toggleIcon2"></i>
                        </button>
                    </div>
                    <button type="submit" class="btn btn-primary">Reset Password</button>
                </form>

            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
        <script>
            // Toggle password visibility for new password field
            document.getElementById('togglePassword1').addEventListener('click', function () {
                const passwordField = document.getElementById('newpassword');
                const toggleIcon = document.getElementById('toggleIcon1');
                const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', type);
                if (toggleIcon.classList.contains('fa-eye-slash')) {
                    toggleIcon.classList.add('fa-eye');
                } else {
                    toggleIcon.classList.add('fa-eye-slash');
                }
            });

            // Toggle password visibility for confirm password field
            document.getElementById('togglePassword2').addEventListener('click', function () {
                const passwordField = document.getElementById('confirmpassword');
                const toggleIcon = document.getElementById('toggleIcon2');
                const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', type);
                if (toggleIcon.classList.contains('fa-eye-slash')) {
                    toggleIcon.classList.add('fa-eye');
                } else {
                    toggleIcon.classList.add('fa-eye-slash');
                }
            });

            // Toggle password visibility for old password field
            document.getElementById('togglePassword3').addEventListener('click', function () {
                const passwordField = document.getElementById('oldpassword');
                const toggleIcon = document.getElementById('toggleIcon3');
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
include '../password.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $oldpassword = $_POST['oldpassword'];
    $newpassword = $_POST['newpassword'];
    $confirmpassword = $_POST['confirmpassword'];

    if ($newpassword == $confirmpassword) {
        // Check if the new password and confirm password match
        $sql = "SELECT * FROM users WHERE userName = '$username'";
        $result = mysqli_query($connection, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            if ($row = mysqli_fetch_assoc($result)) {
                $hash = $row['pass'];
                if (verifyPassword($oldpassword, $hash)) {
                    // Verify old password
                    $hashnewpassword = hashPassword($newpassword);
                    $sql = "UPDATE users SET pass = '$hashnewpassword' WHERE userName = '$username'";
                    $result = mysqli_query($connection, $sql);

                    if ($result) {
                        // Password reset successful
                        echo '<div class="container alert alert-success alert-dismissible fade show mt-3" role="alert">
                        <strong>Success!</strong> Password Reset Successful.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                    } else {
                        // Password reset failed
                        echo '<div class="container alert alert-danger alert-dismissible fade show mt-3" role="alert">
                        <strong>ERROR!!</strong> Password Reset Failed.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                    }
                } else {
                    // Old password is incorrect
                    echo '<div class="container alert alert-danger alert-dismissible fade show mt-3" role="alert">
                <strong>ERROR!!</strong> Old Password is Incorrect.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                }
            } else {
                // User not found
                echo '<div class="container alert alert-danger alert-dismissible fade show mt-3" role="alert">
                <strong>ERROR!!</strong> User not found.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            }
        } else {
            // New password and confirm password do not match
            echo '<div class="container alert alert-danger alert-dismissible fade show mt-3" role="alert">
                <strong>ERROR!!</strong> New Password and Confirm Password do not match.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
    }
}

include '../footer.php';
?>