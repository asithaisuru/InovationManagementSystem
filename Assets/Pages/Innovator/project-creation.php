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
    <title>IMS - Create Project</title>
</head>

<body class="bg-dark text-white">
    <?php include 'innovator-nav.php'; ?>

    <div class="container mt-5 text-white">
        <h2 class="text-center">Create Project</h2>
        <form action="project-creation.php" method="POST">
            <div class="form-floating mb-3 mt-3">
                <input type="text" class="form-control" id="pname" placeholder="Enter Project Name" name="pname"
                    required>
                <label for="pname" class="text-dark">Project Name</label>
            </div>

            <div class="form-floating mb-3 mt-3">
                <textarea class="form-control" id="pdis" name="pdis" rows="10" required></textarea>
                <label for="pdis" class="text-dark">Project Description</label>
            </div>
            <div class="form-floating mb-3 mt-3">
                <select class="form-select mt-3" required name="role" id="role">
                    <option disabled selected></option>
                    <option value="Web Development">Web Development</option>
                    <option value="Mobile Development">Mobile Development</option>
                    <option value="Desktop Development">Desktop Development</option>
                    <option value="Machine Learning">Machine Learning</option>
                    <option value="Data Science">Data Science</option>
                    <option value="Artificial Intelligence">Artificial Intelligence</option>
                    <option value="Cyber Security">Cyber Security</option>
                    <option value="Networking">Networking</option>
                    <option value="Game Development">Game Development</option>
                    <option value="Other">Other</option>
                </select>
                <label for="projectCategory">Project Category</label>
            </div>
            <div class="row">
                <div class="col-md-6 text-center">
                    <div class="form-floating mb-3 mt-3">
                        <input type="date" class="form-control" id="sdate" name="sdate" required>
                        <label for="sdate">Start Date</label>
                    </div>
                </div>
                <div class="col-md-6 text-center">
                    <div class="form-floating mb-3 mt-3">
                        <input type="date" class="form-control" id="edate" name="edate" required>
                        <label for="edate">End Date</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Create Project</button>
        </form>
    </div>
<?php include '../footer.php' ?>
</body>

</html>