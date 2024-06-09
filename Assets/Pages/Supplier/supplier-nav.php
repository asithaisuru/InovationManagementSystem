<?php
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $role = $_SESSION['role'];
    if ($role !='Supplier'){
        echo "<script>window.location.href='../../../index.php';</script>";
        exit();
    }


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
$query = "SELECT * FROM profilePic WHERE userName = '$username'";
$result = mysqli_query($connection, $query);
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $profilePic = "../../img/profilePics/" . $row['image_url'];
} else {
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

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- End of Font Awesome -->
    <title>Supplier-nav</title>
</head>

<body class="text-center">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark text-center">
        <div class="container">
            <a class="navbar-brand" href="./supplier-dashboard.php"><img src="../../img/LogoWhite.png"
                    style="width:50px;height:50px;"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../Supplier/Supplier-dashboard.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Supplier/supplier-dashboard.php#footer">About</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                         Product Management
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="../Supplier/project-creation.php">Add product</a>
                            </li>
                            <li><a class="dropdown-item" href="../Supplier/edit-project.php">Edit productt</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="./delete-project.php">Delete product</a></li>
                        </ul>
                    </li>
                </ul>
                <div class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link me-2 mt-3" href="../chat/chat.php">
                            <i class="fas fa-comment fa-lg" style="color: #ffffff;"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link me-2 mt-3" href="../Forum/forum.php">
                            <i class="fab fa-forumbee fa-lg" style="color: #ffffff;"></i>
                        </a>
                    </li>
                    <li class="nav-item dropdown mt-2">
                        <a class="" href="../Innovator/view-profile.php?userName=<?php echo $username ?>">
                            <img src="<?php echo $profilePic ?>" alt="Profile" class="rounded-circle me-2"
                                style="width:50px;height:50px;">
                        </a>
                    </li>
                    <li class="nav-item dropdown mt-3">
                        <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <span><?php echo $username; ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                            <li><a class="dropdown-item" href="../Admin/profile.php">Edit Profile</a></li>
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
            fetch('../logout.php')
                .then(response => {
                    if (response.ok) {
                        window.location.href = '../../../index.php';
                    } else {
                        console.error('Logout failed');
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    </script>

</body>

</html>