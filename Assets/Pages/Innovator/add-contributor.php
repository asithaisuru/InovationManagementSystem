<?php
session_start();
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $role = $_SESSION['role'];
    if ($role != 'Innovator' && $role != "Admin"  && $role != "Moderator") {
        echo "<script>window.location.href='../../../index.php';</script>";
        exit();
    }
} else {
    // header("Location: ../../../index.php");
    echo "<script>window.location.href='../../../index.php';</script>";
    exit();
}
$pid = $_SESSION['pid'];


include '../dbconnection.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IMS - Add Contributors</title>
</head>

<body class="bg-dark text-white">
    <?php 
    if ($role == 'Innovator') {
        include './innovator-nav.php';
    } elseif ($role == 'Admin' || $role == "Moderator"){
        include '../Admin/admin-nav.php';
    }
    ?>

    <div class="container">

        <?php
        $status = isset($_GET['removecontributor']) ? htmlspecialchars($_GET['removecontributor']) : "";
        if ($status == "success") {
            echo '<div class="container alert alert-success alert-dismissible fade show mt-3" role="alert">
                <strong>Success!</strong> Contributor Removed Successfully.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        } else if ($status == "error") {
            echo '<div class="container alert alert-danger alert-dismissible fade show mt-3" role="alert">
                <strong>ERROR!!</strong> Failed to Remove Contributor.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }

        $status = isset($_GET['addcontributor']) ? htmlspecialchars($_GET['addcontributor']) : "";
        if ($status == "success") {
            echo '<div class="container alert alert-success alert-dismissible fade show mt-3" role="alert">
                <strong>Success!</strong> Contributor Added Successfully.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        } else if ($status == "error") {
            echo '<div class="container alert alert-danger alert-dismissible fade show mt-3" role="alert">
                <strong>ERROR!!</strong> Failed to Add Contributor.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
        ?>
        <h2 class="text-center">Add Contributors</h2>
        <div class="card bg-dark text-white border-white border-3">
            <div class="card-body">
                <form action="add-contributor.php" method="POST">
                    <div class="form-floating mb-3 mt-3">
                        <input type="text" class="form-control" id="cname" placeholder="Enter Contributor Name"
                            name="cname" required>
                        <label for="cname" class="text-dark">Contributor Username</label>
                    </div>
                    <button type="submit" class="btn btn-success">Add Contributor</button>
                </form>

            </div>
        </div>
        <div class="card mt-4 border-white border-3 bg-dark text-white">
            <div class="card-body">
                <h2 class="text-center">Contributors</h2>
                <h5 class="text-center"></h5>
                <div class="table-responsive-lg mt-4">
                    <table class="table table-bordered table-hover table-dark table-lg bg-dark">
                        <thead>
                            <tr>

                                <th class="bg-secondary">Contributor Username</th>
                                <th class="bg-secondary">Contributor name</th>
                                <th class="bg-secondary">Role</th>
                                <th class="bg-secondary">View Profile</th>
                                <th class="bg-secondary">Remove</th>
                                <?php if ($role == 'Admin' || $role == "Moderator") {
                                    echo "<th class='bg-secondary'>Added By</th>";
                                } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM contributors WHERE pid = '$pid';";
                            $result = mysqli_query($connection, $sql);
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . $row['userName'] . "</td>";
                                    // }                            
                                    $sql1 = "SELECT fname, lname, role FROM users WHERE userName = '".$row['userName']."';";
                                    $result1 = mysqli_query($connection, $sql1);
                                    $row1 = mysqli_fetch_assoc($result1);
                                    echo "<td>" . $row1['fname'] . " " . $row1['lname'] . "</td>";
                                    echo "<td>" . $row1['role'] . "</td>";
                                    echo "<td><a class='btn btn-primary text-center d-block' href='./view-profile.php?userName=" . $row['userName'] . "'>View</a></td>";
                                    $sql2 = "SELECT role FROM users WHERE userName = '".$row['addedBy']."';";
                                    $result2 = mysqli_query($connection, $sql2);
                                    $row2 = mysqli_fetch_assoc($result2);
                                    if ($row2['role'] == 'Innovator' || $role == 'Admin' || $role == "Moderator") {
                                        echo "<td><a class='btn btn-danger text-center d-block' href='./remove-contributor.php?userName=" . $row['userName'] . "&pid=" . $pid . "'>Remove</a></td>";
                                        if ($role == 'Admin' || $role == "Moderator") {
                                            if ($row2['role'] == 'Innovator')                                            
                                           echo "<td><p class='text-center'>".$row['addedBy']."</p></td>";
                                        if ($row2['role'] == 'Admin' || $row2['role'] == 'Moderator')                                            
                                           echo "<td><p class='text-center bg-danger'>".$row['addedBy']."</p></td>";
                                        }
                                        echo "";
                                    } else {
                                        echo "<td><p class='text-center'>Unable to remove contributor due to<br>added by an admin</p></td>";
                                    }
                                    // echo "<td><a class='btn btn-danger text-center d-block' href='./remove-contributor.php?userName=" . $row['userName'] . "&pid=" . $pid . "'>Remove</a></td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6' class='text-center'>No records found</td></tr>";
                            }

                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div>
        <?php include '../footer.php'; ?>
    </div>

</body>

</html>


<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cname = $_POST['cname'];
    // echo $cname . "<br>";
    $sql = "SELECT * FROM users WHERE BINARY userName = '$cname'";
    $result = mysqli_query($connection, $sql);
    // echo "result :" . $result;
    // echo mysqli_num_rows($result) . "<br>";
    // echo "pid : " . $_SESSION['pid'] . "<br>";
    if (mysqli_num_rows($result) > 0) {
        $sql = "INSERT INTO contributors (pid, userName,addedBy) VALUES ('$pid', '$cname','$username')";
        $result = mysqli_query($connection, $sql);
        if ($result) {
            echo "<script>window.location.href='./add-contributor.php?addcontributor=success';</script>";
            // echo "<script>alert('Contributor Added Successfully');</script>";
            // echo "<script>window.location.href='add-contributor.php?pid=" . $_SESSION['pid'] . "';</script>";
        } else {
            echo "<script>window.location.href='./add-contributor.php?addcontributor=error';</script>";
            // echo "<script>alert('Failed to Add Contributor');</script>";
            // echo "<script>window.location.href='add-contributor.php?pid=" . $_SESSION['pid'] . "';</script>";
        }
    } else {
        echo "<script>window.location.href='./add-contributor.php?addcontributor=error';</script>";
        // echo "<script>alert('Contributor Not Found');</script>";
        // echo "<script>window.location.href='./add-contributor.php?pid=" . $_SESSION['pid'] . "';</script>";
    }
}
?>