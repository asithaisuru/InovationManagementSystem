<?php
session_start();
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $role = $_SESSION['role'];
    if ($role != "Admin" && $role != "Moderator") {
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
    <title>IMS - View All Tasks</title>
</head>

<body class="bg-dark text-white">

    <?php include 'admin-nav.php'; ?>

    <div class="container">
        <div class="card mt-4 border-white border-3 bg-dark text-white">
            <div class="card-body">
                <h2 class="text-center">All Tasks</h2>
                <div class="mt-3">
                    <form method="GET">
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-lg-2 mb-2">
                                    <select name="filter" id="filter" class="form-select">
                                        <option value="taskID">Task ID</option>
                                        <option value="taskName">Task Name</option>
                                    </select>
                                </div>
                                <div class="col-lg-9 mb-2">
                                    <input type="text" name="keyword" id="keyword" class="form-control">
                                </div>
                                <div class="col-lg-1 mb-2">
                                    <button type="submit" class="btn btn-primary text-center d-block">Filter</button>
                                </div>
                            </div>
                            <!-- <label for="filter" class="form-label">Filter by:</label> -->

                        </div>
                        <!-- <div class="mb-3">
                            <label for="keyword" class="form-label">Keyword:</label>

                        </div> -->

                    </form>
                </div>
                <div class="mt-3 table-responsive">
                    <table class="table table-bordered table-hover table-dark table-lg bg-dark">
                        <thead>
                            <tr>
                                <th>Project ID</th>
                                <th>Task ID</th>
                                <th>Task Name</th>
                                <th>Task Description</th>
                                <th>Task Status</th>
                                <!-- <th>Task Deadline</th> -->
                                <th>Task Assigned To</th>
                                <th>Task Assigned By</th>
                                <th>Task Assigned On</th>
                                <th>Task Updated On</th>
                                <th>View</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM tasks";
                            if (isset($_GET['filter']) && isset($_GET['keyword'])) {
                                $filter = $_GET['filter'];
                                $keyword = $_GET['keyword'];
                                $sql .= " WHERE $filter LIKE '%$keyword%'";
                            }
                            $result = mysqli_query($connection, $sql);
                            if ($result && mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . $row['pid'] . "</td>";
                                    echo "<td>" . $row['taskID'] . "</td>";
                                    echo "<td>" . $row['taskName'] . "</td>";
                                    echo "<td>" . $row['discription'] . "</td>";
                                    if ($row['status'] == "Completed") {
                                        echo "<td class='bg-success'>" . $row['status'] . "</td>";
                                    } else if ($row['status'] == "In Progress") {
                                        echo "<td class='bg-warning'>" . $row['status'] . "</td>";
                                    } else if ($row['status'] == "Not Assigned") {
                                        echo "<td class='bg-danger'>" . $row['status'] . "</td>";
                                    } else if ($row['status'] == "Assigned") {
                                        echo "<td class='bg-info'>" . $row['status'] . "</td>";
                                    } else if ($row['status'] == "Pending") {
                                        echo "<td class='bg-primary'>" . $row['status'] . "</td>";
                                    }
                                    // echo "<td>" . $row['status'] . "</td>";
                                    // echo "<td>" . $row['tdeadline'] . "</td>";
                                    echo "<td>" . $row['assignedTo'] . "</td>";
                                    echo "<td>" . $row['assignedby'] . "</td>";
                                    echo "<td>" . $row['assignedon'] . "</td>";
                                    echo "<td>" . $row['updatedon'] . "</td>";
                                    echo "<td><a href='../Innovator/project-details.php?pid=" . $row['pid'] . "#" . $row['taskID'] . "' class='btn btn-primary'>View</a></td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td class='text-center' colspan='10'>No Tasks Found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


</body>

</html>