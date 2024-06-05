<?php
session_start();
if (isset($_SESSION['username']) || isset($_SESSION['role'])) {
    $username = $_SESSION['username'];
    $role = $_SESSION['role'];
    if ($role != 'Innovator') {
        echo "<script>window.location.href='../../../index.php';</script>";
        exit();
    }
} else {
    // header("Location: ../../../index.php");
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
    <title>IMS - Delete Project</title>
</head>

<body class="bg-dark text-white">
    <?php include 'innovator-nav.php'; ?>

    <div class="container">
        <?php
        // echo $pid;
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
                            $sql = "SELECT * FROM project WHERE userName = '$username';";
                            $result = mysqli_query($connection, $sql);
                            echo "<option disabled selected></option>";
                            if (mysqli_num_rows($result) > 0) {
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

<!-- document.getElementById("getProject").submit(); -->
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pid = $_POST['pid'];
    $sql = "DELETE FROM tasks WHERE pid = '$pid';"; // Removing from tasks
    if (mysqli_query($connection, $sql)) {
        $sql = "DELETE FROM contributors WHERE pid = '$pid';"; // Removing from contributors
        if (mysqli_query($connection, $sql)) {
            $sql = "DELETE FROM project WHERE pid = '$pid';"; // Removing from project
            if (mysqli_query($connection, $sql)) {
                echo "<script>window.location.href='delete-project.php?projectdeletestatus=success';</script>";
                exit();
            } else {
                echo "<script>window.location.href='delete-project.php?projectdeletestatus=error';</script>";
                // echo "Error: " . $sql . "<br>" . mysqli_error($connection);
                exit();
            }
        } else {
            echo "<script>window.location.href='delete-project.php?projectdeletestatus=error';</script>";
            // echo "Error: " . $sql . "<br>" . mysqli_error($connection);
            exit();
        }
    } else {
        echo "<script>window.location.href='delete-project.php?projectdeletestatus=error';</script>";
        // echo "Error: " . $sql . "<br>" . mysqli_error($connection);
        exit();
    }
}
?>