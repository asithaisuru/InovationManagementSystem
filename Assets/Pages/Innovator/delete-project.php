<?php
require_once '../Classes/Innovator.php';
session_start();
if (isset($_SESSION['username']) || isset($_SESSION['role'])) {
    $username = $_SESSION['username'];
    $role = $_SESSION['role'];
    if ($role != 'Innovator') {
        if ($role == 'Admin') {
            echo "<script>window.location.href='../error.php?msj=Access Denied';</script>";
            exit();
        }
        echo "<script>window.location.href='../../../sign-in.php';</script>";
        exit();
    }

    $innovator = new Innovator($username, null);
} else {
    // header("Location: ../../../index.php");
    echo "<script>window.location.href='../../../sign-in.php';</script>";
    exit();
}

include '../dbconnection.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IMS - Delete Project</title>
</head>

<body class="bg-dark text-white">
    <?php include 'innovator-nav.php'; ?>

    <div class="container">
        <?php
        $status = isset($_GET['projectdeletestatus']) ? htmlspecialchars($_GET['projectdeletestatus']) : "";
        if ($status == "success") {
            echo '<div class="container alert alert-success alert-dismissible fade show mt-3" role="alert">
                <strong>Success!</strong> Project Deleted Successfully.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        } else if ($status == "error") {
            echo '<div class="container alert alert-danger alert-dismissible fade show mt-3" role="alert">
                <strong>ERROR!!</strong> Failed to Delete Project.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
        ?>

        <h2 class="text-center">Delete Project</h2>
        <div class="card mt-4 border-white border-3 bg-dark text-white">
            <div class="card-body">
                <form action="delete-project.php" method="POST">
                    <div class="form-floating mb-3 mt-3">
                        <select class="form-select mt-3" required name="pid" id="pid">
                            <?php
                            $result = $innovator->getAllProjectsForAUsername($connection, $username);
                            echo "<option disabled selected></option>";
                            if ($result != "0") {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value=" . $row['pid'] . ">" . $row['pid'] . " - " . $row['pname'] . "</option>";
                                    if ($row['pid'] == htmlspecialchars($_GET['pid'])) {
                                        echo '<script>
                                            document.getElementById("pid").value = ' . htmlspecialchars($_GET['pid']) . ';
                                        </script>';
                                    }
                                }
                            } else {
                                echo "<option disabled>--Projects not found--</option>";
                            }
                            ?>
                        </select>
                        <label for="pid">Select Project</label>
                    </div>
                    <button type="submit" class="btn btn-danger">Delete Project</button>
                </form>

            </div>
        </div>
    </div>

</body>

</html>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $innovator->projectDeleteConfermation($_POST['pid']);
}

if (isset($_GET['confirm']) && $_GET['confirm'] == 'true' && isset($_GET['pid'])) {
    $innovator->deleteAProject($connection, $_GET['pid']);
}
?>