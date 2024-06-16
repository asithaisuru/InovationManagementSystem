<?php
session_start();
if (isset($_SESSION['username']) || isset($_SESSION['role'])) {
    $username = $_SESSION['username'];
    $role = $_SESSION['role'];
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

function getCurrentTime() {
    date_default_timezone_set('Asia/Colombo');
    $current_time = date("Y-m-d H:i:s");
    return $current_time;
}

$query = "SELECT * FROM project WHERE pid = '$pid'";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);
$createdBy = $row['userName'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['taskID']) && isset($_POST['assignedTo'])) {
        $taskID = $_POST['taskID'];
        $assignedTo = $_POST['assignedTo'];
        $time = getCurrentTime();
        $updateQuery = "UPDATE tasks SET assignedTo = '$assignedTo', status = 'Assigned', assignedby = '$username', assignedon='$time' WHERE taskID = '$taskID' AND pid = '$pid'";
        if (!$connection->query($updateQuery)) {
            echo "<script>window.location.href='./project-details.php?projectupdatestatus=error';</script>";
        } else {
            echo "<script>window.location.href='./project-details.php?projectupdatestatus=success';</script>";
        }
    } else if (isset($_POST['status']) && isset($_POST['taskID'])) {
        $status = $_POST['status'];
        $taskID = $_POST['taskID'];
        $time = getCurrentTime();
        $updateStatusQuery = "UPDATE tasks SET status = '$status', updatedon='$time' WHERE taskID = '$taskID' AND pid = '$pid'";
        if (!$connection->query($updateStatusQuery)) {
            echo "<script>window.location.href='./project-details.php?taskstatusupdate=error';</script>";
        } else {
            echo "<script>window.location.href='./project-details.php?taskstatusupdate=success';</script>";
        }
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
    <?php
    if ($role == 'Innovator')
        include './innovator-nav.php';
    elseif ($role == 'Admin' || $role == 'Moderator')
        include '../Admin/admin-nav.php';
    ?>
    <div class="container">
        <?php
        $status = isset($_GET['projectupdatestatus']) ? htmlspecialchars($_GET['projectupdatestatus']) : "";
        $status1 = isset($_GET['taskstatusupdate']) ? htmlspecialchars($_GET['taskstatusupdate']) : "";
        if ($status == "success" || $status1 == "success") {
            echo '<div class="container alert alert-success alert-dismissible fade show mt-3" role="alert">
                <strong>Success!</strong> Tasks Updated Successfully.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        } else if ($status == "error" || $status1 == "error") {
            echo '<div class="container alert alert-danger alert-dismissible fade show mt-3" role="alert">
                <strong>ERROR!!</strong> Failed to Update Tasks.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
        if (isset($_GET['compleateprojectupdatestatus']) == "error") {
            echo '<div class="container alert alert-danger alert-dismissible fade show mt-3" role="alert">
                <strong>ERROR!!</strong> Failed to Update Project Status.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
        ?>
        <h1 class="text-center">Project Details</h1>
        <div class="row mt-4">
            <?php if ($createdBy == $username || $role == "Admin" || $role == "Moderator"): ?>
                <div class="col-lg-3 mb-3">
                    <div class="card border-white border-3 bg-dark text-white">
                        <div class="card-body text-center">
                            <h3 class="card-title text-center">Project Management</h3>
                            <div class="list-group mt-3">
                                <h5 class="card-title mt-3 text-center">Project Options</h5>
                                <a href="./edit-project.php?pid=<?php echo htmlspecialchars($pid); ?>"
                                    class="list-group-item list-group-item-action bg-primary text-white">Edit Project</a>
                                <a href="./delete-project.php?pid=<?php echo htmlspecialchars($pid); ?>"
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
                    <div class="card border-white border-3 bg-dark text-white mt-3">
                        <div class="card-body text-center">
                            <div class="list-group">
                                <h3 class="card-title text-center">Task Status</h3>
                                <?php
                                $query = "SELECT * FROM tasks WHERE pid = '$pid'";
                                $result = mysqli_query($connection, $query);
                                $completedTasks = 0;
                                $pendingTasks = 0;
                                $totalTasks = 0;
                                $notAssignedTasks = 0;
                                if ($result && mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        if ($row['status'] == 'Completed') {
                                            $completedTasks++;
                                        } else if ($row['status'] == 'Pending') {
                                            $pendingTasks++;
                                        } else if ($row['status'] == 'Not Assigned') {
                                            $notAssignedTasks++;
                                        }
                                        $totalTasks++;
                                    }
                                }
                                if ($completedTasks == $totalTasks) {
                                    echo '<div class="alert alert-success mt-3" role="alert">
                                        <strong>Project Completed!</strong>
                                    </div>';
                                    $newQuery = "UPDATE project SET status = 'Completed' WHERE pid = '$pid'";
                                    if (!$connection->query($newQuery)) {
                                        echo "<script>window.location.href='./project-details.php?compleateprojectupdatestatus=error';</script>";
                                        exit();
                                    }
                                } else {
                                    echo '<div class="alert alert-primary mt-3" role="alert">
                                        <strong>Project still ongoing!</strong>
                                    </div>';
                                    $newQuery = "UPDATE project SET status = 'In Progress' WHERE pid = '$pid'";
                                    if (!$connection->query($newQuery)) {
                                        echo "<script>window.location.href='./project-details.php?projectupdatestatus=error';</script>";
                                        exit();
                                    }
                                }
                                ?>
                                <div class="card text-white">
                                    <div class="card-body bg-success">
                                        <h5 class="card-title text-center">Completed</h5>
                                        <h3 class="card-text text-center"><?php echo $completedTasks; ?> /
                                            <?php echo $totalTasks; ?>
                                        </h3>
                                    </div>
                                </div>
                                <div class="card text-white mt-2">
                                    <div class="card-body bg-primary">
                                        <h5 class="card-title text-center">Pending</h5>
                                        <h3 class="card-text text-center"><?php echo $pendingTasks; ?> /
                                            <?php echo $totalTasks; ?>
                                        </h3>
                                    </div>
                                </div>
                                <div class="card text-white mt-2">
                                    <div class="card-body bg-danger">
                                        <h5 class="card-title text-center">Not Assigned</h5>
                                        <h3 class="card-text text-center"><?php echo $notAssignedTasks; ?> /
                                            <?php echo $totalTasks; ?>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <div
                class="<?php echo ($createdBy == $username || $role == "Admin" || $role == "Moderator") ? 'col-lg-9' : 'col-lg-12'; ?>">
                <div class="card border-white border-3 bg-dark text-white">
                    <div class="card-body">
                        <?php
                        $query = "SELECT * FROM project WHERE pid = '$pid'";
                        $result = mysqli_query($connection, $query);
                        $row = mysqli_fetch_assoc($result);
                        echo '<h5 class="text-secondary"><strong>Owner</strong></h5>';
                        $Query = "SELECT fname, lname FROM users WHERE userName = '" . $row['userName'] . "'";
                        $Result = mysqli_query($connection, $Query);
                        $Row = mysqli_fetch_assoc($Result);
                        echo '<h4 class="mt-1"> <a href="./view-profile.php?userName=' . $row['userName'] . '">' . htmlspecialchars($row['userName']) . '</a> - ' . $Row['fname'] . ' ' . $Row['lname'] . '</h4>';
                        echo '<hr class="border-white border-5 ">';
                        echo '<h5 class="text-secondary"><strong>Project Name</strong></h5>';
                        echo '<h2 class="mt-1">' . htmlspecialchars($row['pname']) . '</h2>';
                        echo '<hr class="border-white border-5 ">';
                        echo '<h5 class="text-secondary mt-3"><strong>Project Description</strong></h5>';
                        if ($createdBy == $username) {
                            echo '<p class="">' . htmlspecialchars($row['pdis']) . '</p>';
                        } else {
                            echo '<p class="text-danger">You are not allowed to view the project description</p>';
                        }
                        echo '<hr class="border-white border-5 ">';
                        echo '<h5 class="text-secondary mt-3"><strong>Project Tasks</strong></h5>';
                        echo '<hr class="border-white border-3 ">';
                        $query = "SELECT * FROM tasks WHERE pid = '$pid'";
                        $result = mysqli_query($connection, $query);
                        if ($result && mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                if ($createdBy == $username || $role == "Admin" || $role == "Moderator") {
                                    if ($row['status'] != "Completed" || $role == "Admin" || $role == "Moderator")
                                        echo '<form method="POST" action="project-details.php">';
                                    echo '<span id="' . htmlspecialchars($row['taskID']) . '" class="text-secondary"><small>' . htmlspecialchars($row['taskID']) . '</small> - <span class="text-white">' . htmlspecialchars($row['taskName']) . '</span></span>';
                                    echo '<p class="">' . htmlspecialchars($row['discription']) . '</p>';
                                    echo '<div class="form-floating mb-3 mt-3">';
                                    if ($role != "Admin" || $role != "Moderator")
                                        echo '<select class="form-select mt-3" required name="assignedTo" id="assignedTo"' . (htmlspecialchars($row['status']) == 'Completed' ? ' disabled' : '') . '>';
                                    else
                                        echo '<select class="form-select mt-3" required name="assignedTo" id="assignedTo">';
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
                                    echo '<input type="hidden" name="taskID" value="' . htmlspecialchars($row['taskID']) . '">';
                                    echo '<label for="assignedTo">Assign Task To</label>';
                                    echo '</div>';
                                    echo '<div class="d-block m-2">';
                                    echo '<div class=row>';
                                    echo '<div class=col-lg-10>';
                                    echo '<p class="small">Status: <span class="text-white ' . getStatusClass($row['status']) . ' p-1 ps-2 pe-2">' . htmlspecialchars($row['status']) . '</span></p>';
                                    echo '</div>';
                                    echo '<div class=col-lg-2>';
                                    if ($row['status'] != "Completed" || $role == "Admin" || $role == "Moderator")
                                        echo '<button type="submit" class="btn btn-primary mb-2 ">Update Task</button>';
                                    echo '</div>';
                                    echo '</div>';
                                    echo '</div>';
                                    echo '</form>';
                                    echo '<hr class="border-white border-3 ">';
                                    if ($role == 'Admin' || $role == "Moderator") {
                                        echo '<form method="POST" action="project-details.php">';
                                        echo '<div class="form-floating mb-3 mt-3">';
                                        echo '<select class="form-select mt-3" required name="status" id="status">';
                                        echo '<option value="" selected disabled>-- Select status --</option>';
                                        echo '<option value="Assigned" ' . ($row['status'] == 'Assigned' ? 'selected' : '') . '>Assigned</option>';
                                        echo '<option value="Pending" ' . ($row['status'] == 'Pending' ? 'selected' : '') . '>Pending</option>';
                                        echo '<option value="Completed" ' . ($row['status'] == 'Completed' ? 'selected' : '') . '>Completed</option>';
                                        echo '</select>';
                                        echo '<input type="hidden" name="taskID" value="' . htmlspecialchars($row['taskID']) . '">';
                                        echo '<label for="status">Status</label>';
                                        echo '</div>';
                                        echo '<button type="submit" class="btn btn-primary">Update Status</button>';
                                        echo '</form>';
                                        echo '<hr class="border-white border-5 ">';
                                        echo '<hr class="border-white border-5 ">';
                                        echo '<hr class="border-white border-5 ">';
                                    }
                                } else {
                                    if ($row['assignedTo'] == $username) {
                                        echo '<span class="text-secondary"><small>' . htmlspecialchars($row['taskID']) . '</small> - <span class="text-white">' . htmlspecialchars($row['taskName']) . '</span></span>';
                                        echo '<p class="">' . htmlspecialchars($row['discription']) . '</p>';
                                        echo '<form method="POST" action="project-details.php">';
                                        echo '<div class="form-floating mb-3 mt-3">';
                                        echo '<select class="form-select mt-3" required name="status" id="status">';
                                        echo '<option value="" selected disabled>-- Select status --</option>';
                                        echo '<option value="Assigned" ' . ($row['status'] == 'Assigned' ? 'selected' : '') . '>Assigned</option>';
                                        echo '<option value="Pending" ' . ($row['status'] == 'Pending' ? 'selected' : '') . '>Pending</option>';
                                        echo '<option value="Completed" ' . ($row['status'] == 'Completed' ? 'selected' : '') . '>Completed</option>';
                                        echo '</select>';
                                        echo '<input type="hidden" name="taskID" value="' . htmlspecialchars($row['taskID']) . '">';
                                        echo '<label for="status">Status</label>';
                                        echo '</div>';
                                        echo '<button type="submit" class="btn btn-primary">Update Task</button>';
                                        echo '</form>';
                                        echo '<hr class="border-white border-3 ">';
                                    }
                                }
                            }
                        } else {
                            echo '<p class="text-danger">No Tasks Found</p>';
                        }
                        function getStatusClass($status)
                        {
                            switch ($status) {
                                case 'Completed':
                                    return 'bg-success';
                                case 'Pending':
                                    return 'bg-primary';
                                case 'Not Assigned':
                                    return 'bg-danger';
                                case 'Assigned':
                                    return 'bg-info';
                                default:
                                    return '';
                            }
                        }
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