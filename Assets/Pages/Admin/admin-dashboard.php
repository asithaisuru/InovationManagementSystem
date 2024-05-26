<?php
session_start();
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    // header("Location: ../../../index.php");
    echo "<script>window.location.href='../../../index.php';</script>";
    exit();
}

require_once __DIR__ . '/../../../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../../');
$dotenv->load();

// Database connection
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
    <title>Admin - Dashboard</title>
</head>

<body class="bg-dark text-white border-white border-3">
    <?php include 'admin-nav.php'; ?>

    <div class="container mt-5">
        <h1 class="text-center">Admin Dashboard</h1>
        <div class="card mt-4 border-white border-3 bg-dark text-white" id="add-user">
            <div class="card-body">
                <h1 class="text-white text-center">Add Admin User</h1>
                <form action="add_user.php" method="POST">
                    <div class="form-floating mb-3 mt-3">
                        <input type="text" class="form-control" id="username" placeholder="Enter Username"
                            name="username">
                        <label for="username" class="text-dark">Username</label>
                        <small class="text-secondary"><span class="text-danger">* </span>
                            <span data-bs-toggle="tooltip" data-bs-placement="bottom"
                                title="!@#$%^&*()-=_+[]{}\|;:'&quot;,.<>?/" class="text-white"><kbd>Symbols</kbd></span>
                            and
                            <span data-bs-toggle="tooltip" data-bs-placement="bottom" title=".,:;!?'()[]{}"
                                class="text-white"><kbd>Punctuation marks</kbd></span> are not allowed.
                        </small>
                    </div>
                    <div class="form-floating mb-3 mt-3">
                        <input type="text" class="form-control" id="fname" placeholder="Enter First Name" name="fname"">
                        <label for=" fname" class="text-dark">First Name</label>
                    </div>
                    <div class="form-floating mb-3 mt-3">
                        <input type="text" class="form-control" id="lname" placeholder="Enter Last Name" name="lname">
                        <label for="lname" class="text-dark">Last Name</label>
                    </div>
                    <div class="form-floating mb-3 mt-3">
                        <input type="text" class="form-control" id="email" placeholder="Enter Email" name="email">
                        <label for="lname" class="text-dark">Email</label>
                    </div>
                    <div class="form-floating mt-3 mb-3 position-relative">
                        <input type="password" class="form-control" id="password" placeholder="Enter password"
                            name="password" required>
                        <label for="password" class="text-dark">Password</label>
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
                        <label for="repassword" class="text-dark">Repeat Password</label>
                        <button type="button"
                            class="btn btn-outline-secondary position-absolute top-50 end-0 translate-middle-y border-0"
                            id="togglePassword2"
                            style="border-top-left-radius: 0; border-bottom-left-radius: 0;height:58px;">
                            <i class="fa fa-eye" id="toggleIcon2"></i>
                        </button>
                    </div>
                    <button type="submit" class="btn btn-primary">Add User</button>
                </form>
            </div>
        </div>
    </div>

    <?php
    $status = isset($_GET['status']) ? htmlspecialchars($_GET['status']) : "";
    if ($status == "success") {
        echo '<div class="container alert alert-success alert-dismissible fade show mt-3" role="alert">
        <strong>Success!</strong> Profile created successfully.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
    ?>
    <!-- Remove User Section -->
    <div class="container mt-5">
        <div class="card border-white border-3 bg-dark text-white" id="remove-user">
            <div class="card-body">
                <h1 class="text-center">Remove Admin User</h1>
                <form action="remove_user.php" method="POST">
                    <div class="mb-3">
                        <label for="remove_username" class="form-label">Username:</label>
                        <input type="text" class="form-control" id="remove_username" name="remove_username" required>
                    </div>
                    <button type="submit" class="btn btn-danger">Remove User</button>
                </form>
            </div>
        </div>
    </div>

    <!-- User Table Section -->
    <div class="container mt-5">
        <div class="card border-white border-3 bg-dark text-white" id="admin-list">
            <div class="card-body">
                <h1 class="text-center">Admin List</h1>
                <table class="table table-bordered bg-dark">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($users)):
                            foreach ($users as $user):
                                $query = "SELECT * FROM users WHERE role = 'Admin'";
                                $result = mysqli_query($connection, $query);

                                if ($result && mysqli_num_rows($result) > 0) {
                                    $row = mysqli_fetch_assoc($result);
                                    $fname = $row['fname'];
                                    $lname = $row['lname'];
                                    $email = $row['email'];
                                }
                                ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                                    <td><?php echo htmlspecialchars($user['firstname']); ?></td>
                                    <td><?php echo htmlspecialchars($user['lastname']); ?></td>
                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td><?php echo htmlspecialchars($user['role']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">No users found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>



    <!-- Bootstrap Bundle with Popper -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <div id="footer">
        <?php include '../footer.php'; ?>
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