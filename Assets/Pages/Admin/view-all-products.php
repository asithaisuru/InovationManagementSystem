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
include '../dbconnection.php';
require_once "../Classes/Administrator.php";
$admin = new Administrator(null, null);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IMS - Manage Products</title>
</head>

<body class="bg-dark text-white">

    <?php include 'admin-nav.php'; ?>

    <div class="container">
        <div class="card mt-4 border-white border-3 bg-dark text-white">
            <div class="card-body">
                <h2 class="text-center">Product Approval List</h2>
                <!-- <div class="mt-3">
                    <form method="GET">
                        <div class="mb-3">
                            <div class="row">

                                <div class="col-lg-11 mb-2">
                                    <input type="text" name="keyword" id="keyword" class="form-control"
                                        placeholder="Product Name">
                                </div>
                                <div class="col-lg-1 mb-2">
                                    <button type="submit" class="btn btn-primary text-center d-block">Filter</button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div> -->
                <div class="mt-3 table-responsive">
                    <table class="table table-bordered table-hover table-dark table-lg bg-dark">
                        <thead>
                            <tr>
                                <th>Project ID</th>
                                <th>Task ID</th>
                                <th>Task Name</th>
                                <!-- <th>Task Description</th> -->
                                <th>Task Status</th>
                                <!-- <th>Task Deadline</th> -->
                                <th>Task Assigned To</th>
                                <th>View</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM items ORDER BY prodId DESC";
                            $result = $admin->sqlExecutor($connection, $sql);
                            if ($result != null) {
                                // $result = mysqli_query($connection, $sql);
                                // if ($result && mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . $row['prodId'] . "</td>";
                                    echo "<td>" . $row['prodName'] . "</td>";
                                    echo "<td>" . $row['prodPrice'] . "</td>";
                                    echo "<td>" . $row['userName'] . "</td>";
                                    // echo "<tdෆ>" . $row['discription'] . "</tdෆ>";
                                    if ($row['status'] == "Approved") {
                                        echo "<td class='bg-success'>" . $row['status'] . "</td>";
                                    } else if ($row['status'] == "Pending") {
                                        echo "<td class='bg-warning'>" . $row['status'] . "</td>";
                                    } else if ($row['status'] == "Rejected") {
                                        echo "<td class='bg-danger'>" . $row['status'] . "</td>";
                                    }
                                    // echo "<td>" . $row['status'] . "</td>";
                                    // echo "<td>" . $row['tdeadline'] . "</td>";                                    
                                    echo "<td><a href='../Supplier/view-prod.php?prodId=" . $row['prodId']. "' class='btn btn-primary'>View</a></td>";
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
<?php include '../footer.php'; ?>   

</html>