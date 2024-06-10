<?php
// Check if the user is logged in
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $role = $_SESSION['role'];
} else {
    // If not logged in, redirect to the index page
    echo "<script>window.location.href='../../../index.php';</script>";
    exit();
}

// Load the dotenv library
require_once __DIR__ . '/../../../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../../');
$dotenv->load();

// Establish database connection
$connection = mysqli_connect($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $_ENV['DB_NAME']);
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve the user's profile picture from the database
$query = "SELECT * FROM profilePic WHERE userName = '$username'";
$result = mysqli_query($connection, $query);
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $profilePic = "../../img/profilePics/" . $row['image_url'];
} else {
    // If no profile picture found, use a default image
    $profilePic = "https://img.freepik.com/free-vector/blue-circle-with-white-user_78370-4707.jpg?t=st=1716576375~exp=1716579975~hmac=be6ca419460bee7ca7e72244b5462a3ce71eff32f244d69b7646c4e984e6f4ee&w=740";
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

    <title>Admin-nav</title>
</head>

<body class="text-center text-white">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark text-center">
        <div class="container">
            <a class="navbar-brand" href="admin-dashboard.php"><img src="../../img/LogoWhite.png"
                    style="width:50px;height:50px;"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <!-- User Management -->
                    <li class="nav-item">
                        <a class="nav-link" href="../Admin/admin-dashboard.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Admin/admin-dashboard.php#footer">About</a>
                    </li>
                    <?php if ($_SESSION['role'] !== "Moderator"): ?>
                        <div id="user_management">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Admin Management
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="../Admin/user-management.php#add-user">Add User</a></li>
                                    <li><a class="dropdown-item" href="../Admin/user-management.php#remove-user">Remove User</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="../Admin/user-management.php#admin-list">View all users</a></li>
                                </ul>
                            </li>
                        </div>
                    <?php endif; ?>
                    <!-- User Management -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            User Management
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="../Admin/user-password-reset.php"> Reset Password</a></li>
                            <!-- <li><a class="dropdown-item" href="#">Remove User</a></li> -->
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="../Admin/viewAllUser.php">View All Users</a></li>
                        </ul>
                    </li>
                    <!-- project management -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Project Management
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <!-- <li><a class="dropdown-item" href="#"> Change Project detalis</a></li> -->
                            <li><a class="dropdown-item" href="./view-all-tasks.php">View all tasks</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="../Admin/view-all-projects.php">View All Projects</a></li>
                        </ul>
                    </li>
                </ul>
                <div class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="<?php echo $profilePic ?>" alt="Profile" class="rounded-circle me-2"
                                style="width:50px;height;50px;">
                            <span><?php echo $username; ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                            <li><a class="dropdown-item" href="../Admin/profile.php">Profile</a></li>
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li><a class="dropdown-item" href="../Admin/resetpassword.php">Reset Password</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" onclick="logout()">Logout</a></li>
                        </ul>
                    </li>
                </div>
            </div>
        </div>
    </nav>
    <hr class="text-white border-3">

    <script>
        function logout() {
            // Perform logout action using fetch API
            fetch('../logout.php')
                .then(response => {
                    if (response.ok) {
                        // Redirect to the login page after logout
                        window.location.href = '../../../index.php'; // Replace "login.php" with the actual path to your login page
                    } else {
                        console.error('Logout failed');
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
</body>

</html>