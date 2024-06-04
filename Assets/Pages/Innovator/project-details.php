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

$query = "SELECT * FROM project WHERE pid = '$pid'";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);
$createdBy = $row['userName'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['taskID']) && isset($_POST['assignedTo'])) {
        $taskIDs = $_POST['taskID'];
        $assignedTo = $_POST['assignedTo'];

        for ($i = 0; $i < count($taskIDs); $i++) {
            $taskID = $taskIDs[$i];
            $user = $assignedTo[$i];

            $updateQuery = "UPDATE tasks SET assignedTo = '$user', status = 'Pending' WHERE taskID = '$taskID' AND pid = '$pid'";
            if (!$connection->query($updateQuery)) {
                echo "<script>window.location.href='./project-details.php?projectupdatestatus=error';</script>";
            } else {
                echo "<script>window.location.href='./project-details.php?projectupdatestatus=success';</script>";
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
    <title>IMS - Project Details</title>
</head>

<body class="bg-dark text-white">
    <?php include './innovator-nav.php'; ?>
    <div class="container">

        <?php
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
            <div class="col-lg-3 mb-3">
                <div class="card border-white border-3 bg-dark text-white">
                    <div class="card-body text-center">
                        <h3 class="card-title text-center">Project Management</h3>
                        <div class="list-group mt-3">
                            <h5 class="card-title mt-3 text-center">Project Options</h5>
                            <?php if ($createdBy == $username): ?>
                                <a href="./edit-project.php?pid=<?php echo htmlspecialchars($pid); ?>"
                                    class="list-group-item list-group-item-action bg-primary text-white">Edit Project</a>
                                <a href="./delete-project.php"
                                    class="list-group-item list-group-item-action bg-danger text-white">Delete Project</a>
                            <?php else: ?>
                                <a href="#" class="list-group-item list-group-item-action disabled"
                                    aria-disabled="true">Edit Project</a>
                                <a href="#" class="list-group-item list-group-item-action disabled"
                                    aria-disabled="true">Delete Project</a>
                            <?php endif; ?>
                        </div>
                        <div class="list-group mt-3">
                            <h5 class="card-title mt-3 text-center">Contributors Options</h5>
                            <?php if ($createdBy == $username): ?>
                                <a href="./add-contributor.php?pid=<?php echo htmlspecialchars($pid); ?>"
                                    class="list-group-item list-group-item-action bg-success text-white">Manage
                                    Contributors</a>
                            <?php else: ?>
                                <a href="#" class="list-group-item list-group-item-action disabled"
                                    aria-disabled="true">Manage Contributors</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="card border-white border-3 bg-dark text-white">
                    <div class="card-body">
                       
                            <?php
                            $query = "SELECT * FROM project WHERE pid = '$pid'";
                            $result = mysqli_query($connection, $query);
                            $row = mysqli_fetch_assoc($result);                            

                            echo '<h5 class="text-secondary"><strong>Owner</strong></h5>';
                            $Query = "SELECT fname, lname FROM users WHERE userName = '".$row['userName']."'";
                            $Result = mysqli_query($connection, $Query);
                            $Row = mysqli_fetch_assoc($Result);                            
                            echo '<h4 class="mt-1">' . htmlspecialchars($row['userName']) . ' - '.$Row['fname'].' '. $Row['lname'].'</h4>';
                            echo '<hr class="border-white border-5 ">';

                            echo '<h5 class="text-secondary"><strong>Project Name</strong></h5>';
                            echo '<h2 class="mt-1">' . htmlspecialchars($row['pname']) . '</h2>';
                            echo '<hr class="border-white border-5 ">';

                            if ($createdBy == $username) {
                                echo '<h5 class="text-secondary mt-3"><strong>Project Description</strong></h5>';
                                echo '<p class="">' . htmlspecialchars($row['pdis']) . '</p>';
                                echo '<hr class="border-white border-5 ">';
                            } else {
                                echo '<h5 class="text-secondary mt-3"><strong>Project Description</strong></h5>';
                                echo '<p class="text-danger">You are not allowed to view the project description</p>';
                                echo '<hr class="border-white border-5 ">';
                            }

                            echo '<h5 class="text-secondary mt-3"><strong>Project Tasks</strong></h5>';
                            echo '<hr class="border-white border-3 ">';

                            $query = "SELECT * FROM tasks WHERE pid = '$pid'";
                            $result = mysqli_query($connection, $query);
                            echo "</form>";
                            if ($result && mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    if ($createdBy == $username) {
                                        echo '<form method="POST" action="project-details.php">';
                                        echo '<span class="text-secondary"><small>' . htmlspecialchars($row['taskID']) . '</small> - <span class="text-white">' . htmlspecialchars($row['taskName']) . '</span></span>';
                                        echo '<p class="">' . htmlspecialchars($row['discription']) . '</p>';
                                        echo '<div class="form-floating mb-3 mt-3">';
                                        echo '<select class="form-select mt-3" required name="assignedTo[]" id="assignedTo">';
                                        echo '<option value="" selected disabled>-- Select Innovator --</option>';

                                        $sql = "SELECT * FROM contributors WHERE pid = '$pid'";
                                        $result1 = mysqli_query($connection, $sql);
                                        if ($result1 && mysqli_num_rows($result1) > 0) {
                                            while ($row1 = mysqli_fetch_assoc($result1)) {
                                                if ($createdBy != $username && $username == $row1['userName']) {
                                                    $selected = $row['assignedTo'] == $row1['userName'] ? 'selected' : '';
                                                    echo '<option value="' . htmlspecialchars($row1["userName"]) . '" ' . $selected . '>' . htmlspecialchars($row1["userName"]) . '</option>';
                                                } elseif ($createdBy == $username) {
                                                    $selected = $row['assignedTo'] == $row1['userName'] ? 'selected' : '';
                                                    echo '<option value="' . htmlspecialchars($row1["userName"]) . '" ' . $selected . '>' . htmlspecialchars($row1["userName"]) . '</option>';
                                                }
                                            }
                                        } else {
                                            echo '<option value="" disabled>No Contributors Found</option>';
                                        }
                                        echo '</select>';
                                        echo '<input type="hidden" name="taskID[]" value="' . htmlspecialchars($row['taskID']) . '">';
                                        echo '<label for="assignedTo">Assign Task To</label>';
                                        echo '</div>';
                                        echo '<hr class="border-white border-3 ">';
                                    } else {
                                        if ($row['assignedTo'] == $username) {
                                            echo '<span class="text-secondary"><small>' . htmlspecialchars($row['taskID']) . '</small> - <span class="text-white">' . htmlspecialchars($row['taskName']) . '</span></span>';
                                            echo '<p class="">' . htmlspecialchars($row['discription']) . '</p>';
                                            echo '<div class="form-floating mb-3 mt-3">';
                                            echo '<select class="form-select mt-3" required name="assignedTo[]" id="assignedTo" disabled>';
                                            echo '<option value="" selected disabled>-- Select Innovator --</option>';
                                            $sql = "SELECT * FROM contributors WHERE pid = '$pid'";
                                            $result1 = mysqli_query($connection, $sql);
                                            if ($result1 && mysqli_num_rows($result1) > 0) {
                                                while ($row1 = mysqli_fetch_assoc($result1)) {
                                                    if ($createdBy != $username && $username == $row1['userName']) {
                                                        $selected = $row['assignedTo'] == $row1['userName'] ? 'selected' : '';
                                                        echo '<option value="' . htmlspecialchars($row1["userName"]) . '" ' . $selected . '>' . htmlspecialchars($row1["userName"]) . '</option>';
                                                    }
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

                                    }
                                }




                            } else {
                                echo '<p class="text-danger">No Tasks Found</p>';
                            }

                            ?>
                            <?php if ($createdBy == $username)
                                echo '<button type="submit" class="btn btn-primary">Update Tasks</button>';
                            ?>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include '../footer.php'; ?>
</body>

</html>

<?php $connection->close(); ?>