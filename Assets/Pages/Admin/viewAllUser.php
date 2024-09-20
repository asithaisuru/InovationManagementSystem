<?php
session_start();
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $role = $_SESSION['role'];
    if ($role != 'Admin') {
        echo "<script>window.location.href='../../../sign-in.php';</script>";
        exit();
    }
} else {
    echo "<script>window.location.href='../../../sign-in.php';</script>";
    exit();
}

require_once "../Classes/Administrator.php";
$admin = new Administrator(null, null);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IMS - View All Users</title>
</head>

<body class="bg-dark">
    <?php include 'admin-nav.php'; ?>
    <div class="container mt-5">
        <div class="card border-white border-3 bg-dark text-white">
            <div class="card-body">
                <h1 class="text-center">View All Users</h1>
                <div class="row mb-3">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <form method="GET" action="">
                                <label for="role" class="text-white">Filter by Role:</label>
                                <select name="role" id="role" class="form-control">
                                    <option value="">All</option>
                                    <option value="Innovator">Innovator</option>
                                    <option value="Supplier">Supplier</option>
                                </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="UserName" class="text-white">Filter by Username:</label>
                            <input type="text" name="UserName" id="UserName" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="name" class="text-white">Filter by Name:</label>
                            <input type="text" name="name" id="name" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="email" class="text-white">Filter by email:</label>
                            <input type="text" name="email" id="email" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary d-block w-100">Filter</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="table-responsive-lg">
                    <table class="table table-bordered table-hover table-dark table-lg bg-dark">
                        <thead>
                            <tr>
                                <th class="bg-secondary">Username</th>
                                <th class="bg-secondary">First Name</th>
                                <th class="bg-secondary">Last Name</th>
                                <th class="bg-secondary">Email</th>
                                <th class="bg-secondary">Role</th>
                                <th class="bg-secondary">View</th>
                                <th class="bg-secondary">Reset Password</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM users WHERE role!='Admin'";
                            if (isset($_GET['role']) && !empty($_GET['role'])) {
                                $role = $_GET['role'];
                                $sql .= " AND role='$role'";
                            }
                            if (isset($_GET['email']) && !empty($_GET['email'])) {
                                $email = $_GET['email'];
                                $sql .= " AND (email LIKE '%$email%')";
                            }
                            if (isset($_GET['UserName']) && !empty($_GET['UserName'])) {
                                $UserName = $_GET['UserName'];
                                $sql .= " AND (userName LIKE '%$UserName%')";
                            }
                            if (isset($_GET['name']) && !empty($_GET['name'])) {
                                $name = $_GET['name'];
                                $sql .= " AND (fname LIKE '%$name%' OR lname LIKE '%$name%')";
                            }

                            $result = $admin->sqlExecutor($connection, $sql);
                            if ($result != null) {
                                // $result = mysqli_query($connection, $sql);
                                // if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . $row['userName'] . "</td>";
                                    echo "<td>" . $row['fname'] . "</td>";
                                    echo "<td>" . $row['lname'] . "</td>";
                                    echo "<td>" . $row['email'] . "</td>";
                                    echo "<td>" . $row['role'] . "</td>";
                                    echo "<td><a class='btn btn-primary text-center d-block' href='../Innovator/view-profile.php?userName=" . $row['userName'] . "'>View</a></td>";
                                    echo "<td><a class='btn btn-danger text-center d-block' href='../Admin/user-password-reset.php?userName=" . $row['userName'] . "'>Reset Password</a></td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td class='text-center' colspan='7'>No records found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="text-white">
        <?php include '../footer.php'; ?>
    </div>
</body>


</html>