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
    echo "<script>window.location.href='../../../index.php';</script>";
    exit();
}

if (isset($_GET['pid'])) {
    $pid = $_GET['pid'];
    $_SESSION['pid'] = $pid;
} else {
    $pid = $_SESSION['pid'];
}

include '../dbconnection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['taskID']) && isset($_POST['assignedTo'])) {
        $taskIDs = $_POST['taskID'];
        $assignedTo = $_POST['assignedTo'];

        for ($i = 0; $i < count($taskIDs); $i++) {
            $taskID = $taskIDs[$i];
            $user = $assignedTo[$i];

            $updateQuery = "UPDATE tasks SET assignedTo = '$user' WHERE taskID = '$taskID' AND pid = '$pid'";
            if (!$connection->query($updateQuery)) {
                // echo "Error updating record: " . $connection->error;
                echo "<script>window.location.href='./project-details.php?projectupdatestatus=error';</script>";
            }else{
                echo "<script>window.location.href='./project-details.php?projectupdatestatus=success';</script>";
                // echo "Record updated successfully";
            }
        }
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IMS- Project Details</title>
</head>

<body class="bg-dark text-white">
    <?php include './innovator-nav.php'; ?>
    <div class="container">

        <?php
        // echo $pid;
        $status = isset($_GET['projectupdatestatus']) ? htmlspecialchars($_GET['projectupdatestatus']) : "";
        if ($status == "success") {
            echo '<div class="container alert alert-success alert-dismissible fade show mt-3" role="alert">
                <strong>Success!</strong> Tasks Updated Successfully.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        } else if ($status == "error") {
            echo '<div class="container alert alert-danger alert-dismissible fade show mt-3" role="alert">
                <strong>ERROR!!</strong> Failed to Update Tasks.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
        ?>

        <h1 class="text-center">Project Details</h1>
        <div class="row mt-4">
            <div class="col-lg-3">
                <div class="card border-white border-3 bg-dark text-white">
                    <div class="card-body text-center">
                        <h3 class="card-title text-center">Project Management</h3>
                        <div class="list-group mt-3">
                            <h5 class="card-title mt-3 text-center">Project Options</h5>
                            <a href="./edit-project.php?pid=<?php echo htmlspecialchars($pid); ?>"
                                class="list-group-item list-group-item-action bg-primary text-white">Edit Project</a>
                            <a href="./delete-project.php"
                                class="list-group-item list-group-item-action bg-danger text-white">Delete Project</a>
                        </div>
                        <div class="list-group mt-3">
                            <h5 class="card-title mt-3 text-center">Contributors Options</h5>
                            <a href="./add-contributor.php?pid=<?php echo htmlspecialchars($pid); ?>"
                                class="list-group-item list-group-item-action bg-success text-white">Manage
                                Contributors</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="card border-white border-3 bg-dark text-white">
                    <div class="card-body">
                        <form method="POST" action="project-details.php">
                            <?php
                            $query = "SELECT * FROM project WHERE pid = '$pid'";
                            $result = mysqli_query($connection, $query);
                            $row = mysqli_fetch_assoc($result);
                            echo '<h5 class="text-secondary"><strong>Project Name</strong></h5>';
                            echo '<h2 class="mt-1">' . htmlspecialchars($row['pname']) . '</h2>';
                            echo '<hr class="border-white border-5 ">';

                            echo '<h5 class="text-secondary mt-3"><strong>Project Description</strong></h5>';
                            echo '<p class="">' . htmlspecialchars($row['pdis']) . '</p>';
                            echo '<hr class="border-white border-5 ">';

                            echo '<h5 class="text-secondary mt-3"><strong>Project Tasks</strong></h5>';
                            echo '<hr class="border-white border-3 ">';

                            $query = "SELECT * FROM tasks WHERE pid = '$pid'";
                            $result = mysqli_query($connection, $query);

                            if ($result && mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<span class="text-secondary"><small>' . htmlspecialchars($row['taskID']) . '</small> - <span class="text-white">' . htmlspecialchars($row['taskName']) . '</span></span>';
                                    echo '<p class="">' . htmlspecialchars($row['discription']) . '</p>';
                                    echo '<div class="form-floating mb-3 mt-3">';
                                    echo '<select class="form-select mt-3" required name="assignedTo[]" id="assignedTo">';
                                    echo '<option value="" selected disabled>-- Select Innovator --</option>';

                                    $sql = "SELECT * FROM contributors WHERE pid = '$pid'";
                                    $result1 = mysqli_query($connection, $sql);
                                    if ($result1 && mysqli_num_rows($result1) > 0) {
                                        while ($row1 = mysqli_fetch_assoc($result1)) {
                                            $selected = $row['assignedTo'] == $row1['userName'] ? 'selected' : '';
                                            echo '<option value="' . htmlspecialchars($row1["userName"]) . '" ' . $selected . '>' . htmlspecialchars($row1["userName"]) . '</option>';
                                        }
                                    } else {
                                        echo '<option value="" disabled>No Contributors Found</option>';
                                    }
                                    echo '</select>';
                                    echo '<input type="hidden" name="taskID[]" value="' . htmlspecialchars($row['taskID']) . '">';
                                    echo '<label for="assignedTo">Assign Task To</label>';
                                    echo '</div>';
                                    echo '<hr class="border-white border-3 ">';
                                }
                            } else {
                                echo '<p class="text-danger">No Tasks Found</p>';
                            }

                            ?>
                            <button type="submit" class="btn btn-primary">Update Tasks</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include '../footer.php'; ?>
</body>

</html>

<?php $connection->close(); ?>