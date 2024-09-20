<?php

require_once "../Classes/Administrator.php";
session_start();
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $role = $_SESSION['role'];
    if ($role != 'Admin') {
        echo "<script>window.location.href='../../../sign-in.php';</script>";
        exit();
    }
} else {
    // header("Location: ../../../index.php");
    echo "<script>window.location.href='../../../sign-in.php';</script>";
    exit();
}

$admin = new Administrator(null, null);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IMS - View All Projects</title>
</head>

<body class="bg-dark text-white">
    <?php include 'admin-nav.php'; ?>

    <div class="container">
        <div class="card mt-4 border-white border-3 bg-dark text-white">
            <div class="card-body">
                <h2 class="text-center">All Projects</h2>
                <div class="mt-3">
                    <form method="GET">
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-lg-2 mb-2">
                                    <select name="filter" id="filter" class="form-select">
                                        <option value="id">Project ID</option>
                                        <option value="name">Project Name</option>
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
                                <th class="bg-secondary">Project ID</th>
                                <th class="bg-secondary">Project Name</th>
                                <th class="bg-secondary">Project Category</th>
                                <th class="bg-secondary">Project Status</th>
                                <th class="bg-secondary">View</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM project";
                            if (isset($_GET['filter']) && !empty($_GET['filter']) && isset($_GET['keyword']) && !empty($_GET['keyword'])) {
                                $keyword = $_GET['keyword'];
                                if ($_GET['filter'] == 'id') {
                                    $filter = 'pid';
                                    $sql .= " WHERE pid='$keyword'";
                                } else if ($_GET['filter'] == 'name') {
                                    $filter = 'pname';
                                    $sql .= " WHERE $filter LIKE '%$keyword%'";
                                }
                            }

                            $result1 = $admin->sqlExecutor($connection, $sql);
                            // $result1 = mysqli_query($connection, $sql);
                            // if (mysqli_num_rows($result1) > 0) {
                            if ($result1 != null) {
                                while ($row1 = mysqli_fetch_assoc($result1)) {
                                    echo "<tr>";
                                    echo "<td>" . $row1['pid'] . "</td>";
                                    echo "<td>" . $row1['pname'] . "</td>";
                                    echo "<td>" . $row1['pcategory'] . "</td>";

                                    if ($row1['status'] == 'Completed')
                                        echo "<td class='text-center bg-success'>" . $row1['status'] . "</td>";
                                    else if ($row1['status'] == 'In Progress')
                                        echo "<td class='text-center bg-warning text-white'>" . $row1['status'] . "</td>";
                                    else
                                        echo "<td class='text-center bg-warning text-dark'></td>";
                                    echo "<td><a href='../Innovator/project-details.php?pid=" . $row1['pid'] . "' class='btn btn-primary text-center d-block'>View</a></td>";
                                    echo "</tr>";
                                }
                            } else
                                echo "<tr><td colspan='5' class='text-center'>No Projects Found</td></tr>";
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
<?php include '../footer.php'; ?>

</html>