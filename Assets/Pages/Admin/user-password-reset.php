<?php
session_start();
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $role = $_SESSION['role'];
} else {
    echo "<script>window.location.href='../../../index.php';</script>";
    exit();
}
include '../dbconnection.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IMS - Reset Password</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-dark text-white">
    <?php include 'admin-nav.php'; ?>

    <div class="container">

        <?php
        $status = isset($_GET['userpasswordreset']) ? htmlspecialchars($_GET['userpasswordreset']) : "";
        if ($status == "success") {
            echo '<div class="container alert alert-success alert-dismissible fade show mt-3" role="alert">
                <strong>Success!</strong> Password reset successfully.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        } else if ($status == "error") {
            echo '<div class="container alert alert-danger alert-dismissible fade show mt-3" role="alert">
                <strong>ERROR!!</strong> Password reset failed.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        }
        ?>

        <div class="card bg-dark text-white border-3 border-white">
            <div class="card-body">
                <h1 class="text-center">Reset Password</h1>
                <form action="user-password-reset.php" method="POST">
                    <div class="form-floating mb-3 mt-3">
                        <input type="text" class="form-control" id="username" placeholder="Username" name="username"
                            required value="<?php echo isset($_GET['userName']) ? htmlspecialchars($_GET['userName']) : '' ?>">
                        <label for="username" class="text-dark">Username</label>
                    </div>
                    <div class="form-floating mt-3 mb-3 position-relative">
                        <input type="password" class="form-control" id="password" placeholder="Enter password"
                            name="password" required>
                        <label for="password" class="text-dark">Password</label>
                        <button type="button"
                            class="btn btn-outline-secondary position-absolute top-50 end-0 translate-middle-y border-0"
                            id="togglePassword"
                            style="border-top-left-radius: 0; border-bottom-left-radius: 0;height:58px;">
                            <i class="fa fa-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                    <button type="submit" class="btn btn-primary">Reset Password</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordField = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            toggleIcon.classList.toggle('fa-eye-slash');
        });
    </script>
</body>

<?php include '../footer.php'; ?>

</html>

<?php
include '../password.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $passwordresetusername = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

    $sendingPassword = hashPassword($password);

    $sql = "UPDATE users SET pass = ? WHERE userName = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param('ss', $sendingPassword, $passwordresetusername);

    if ($stmt->execute()) {
        echo "<script>window.location.href='./user-password-reset.php?userpasswordreset=success';</script>";
    } else {
        echo "<script>window.location.href='./user-password-reset.php?userpasswordreset=error';</script>";
    }

    $stmt->close();
    $connection->close();
}
?>