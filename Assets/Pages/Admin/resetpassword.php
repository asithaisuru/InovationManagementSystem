<?php
session_start();
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    // header("Location: ../../../index.php");
    echo "<script>window.location.href='../../../index.php';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body class="bg-dark text-white text-center">
    <?php
    if ($_SESSION['role'] == "Admin") {
        include './admin-nav.php';
    } else if ($_SESSION['role'] == "Innovator") {
        include '../Innovator/innovator-nav.php';
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
                    <div class="form-floating mb-3 mt-3">
                        <input type="password" class="form-control" id="oldpassword" placeholder="Enter Old Password"
                            name="oldpassword" required>
                        <label for="oldpassword" class="text-dark">Old Password</label>
                    </div>
                    <div class="form-floating mb-3 mt-3">
                        <input type="password" class="form-control" id="newpassword" placeholder="Enter New Password"
                            name="newpassword" required>
                        <label for="newpassword" class="text-dark">New Password</label>
                    </div>
                    <div class="form-floating mb-3 mt-3">
                        <input type="password" class="form-control" id="confirmpassword"
                            placeholder="Confirm New Password" name="confirmpassword" required>
                        <label for="confirmpassword" class="text-dark">Confirm New Password</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Reset Password</button>
                </form>

            </div>
        </div>

</body>

</html>


<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $oldpassword = $_POST['oldpassword'];
    $newpassword = $_POST['newpassword'];
    $confirmpassword = $_POST['confirmpassword'];
    // echo $oldpassword.'<br>';
    // echo $newpassword.'<br>';
    // echo $confirmpassword.'<br>';

    if ($newpassword == $confirmpassword) {
        // echo "password match";
        $sql = "SELECT * FROM users WHERE userName = '$username' AND pass = '$oldpassword'";
        $result = mysqli_query($connection, $sql);
        // echo mysqli_num_rows($result);
        if ($result && mysqli_num_rows($result) > 0) {
            $sql = "UPDATE users SET pass = '$newpassword' WHERE userName = '$username'";
            $result = mysqli_query($connection, $sql);
            // echo $result;
            if ($result) {
                echo '<div class="container alert alert-success alert-dismissible fade show mt-3" role="alert">
                        <strong>Success!</strong> Password Reset Successful.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
            } else {
                echo '<div class="container alert alert-danger alert-dismissible fade show mt-3" role="alert">
                        <strong>ERROR!!</strong> Password Reset Failed.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
            }
        } else {
            echo '<div class="container alert alert-danger alert-dismissible fade show mt-3" role="alert">
                <strong>ERROR!!</strong> Old Password is Incorrect.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
    } else {
        // echo 'password do not match';
        echo '<div class="container alert alert-danger alert-dismissible fade show mt-3" role="alert">
                <strong>ERROR!!</strong> New Password and Confirm Password do not match.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }
}

include '../footer.php';
?>