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
    <title>Innovator - Dashboard</title>
    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
        (function () {
            var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/664344a19a809f19fb30bb2f/1htrc868i';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
    <!--End of Tawk.to Script-->
</head>

<body class="bg-dark text-white">
    <?php include 'innovator-nav.php'; ?>

    <div class="container mt-5">
        <h2 class="text-center">Innovator Dashboard</h2>
        <div class="card mt-4 border-white border-3 bg-dark text-white">
            <div class="card-body">
                <h2 class="text-center">Project Management</h2>
                <div class="row mt-4">
                    <div class="col-lg-4 mb-2">
                        <a href="./project-creation.php" class="btn btn-success d-block">Create Project</a>
                    </div>
                    <div class="col-lg-4 mb-2">
                        <a href="./delete-project.php" class="btn btn-danger d-block">Delete Project</a>
                    </div>
                    <div class="col-lg-4 mb-2">
                        <a href="./edit-project.php" class="btn btn-primary d-block">Edit Project</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4 border-white border-3 bg-dark text-white">
            <div class="card-body">
                <h2 class="text-center">My Projects</h2>
                <div class="table-responsive-lg mt-4">
                    <table class="table table-bordered table-hover table-dark table-lg bg-dark">
                        <thead>
                            <tr>
                                <th class="bg-secondary">Project ID</th>
                                <th class="bg-secondary">Project Name</th>
                                <!-- <th class="bg-secondary">Project Description</th> -->
                                <th class="bg-secondary">Start Date</th>
                                <th class="bg-secondary">End Date</th>
                                <th class="bg-secondary">View Project</th>
                                <th class="bg-secondary">Project Status</th>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM project WHERE userName = '$username';";
                            $result = mysqli_query($connection, $sql);
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . $row['pid'] . "</td>";
                                    echo "<td>" . $row['pname'] . "</td>";
                                    // echo "<td>" . $row['pdis'] . "</td>";
                                    echo "<td>" . $row['sdate'] . "</td>";
                                    echo "<td>" . $row['edate'] . "</td>";
                                    echo "<td><a class='btn btn-primary text-center d-block' href='./project-details.php?pid=" . $row['pid'] . "'>View</a></td>";
                                    if ($row['status'] == 'Completed')
                                        echo "<td class = 'text-center bg-success'>" . $row['status'] . "</td>";
                                    else if ($row['status'] == 'In Progress')
                                        echo "<td class = 'text-center bg-warning text-white'>" . $row['status'] . "</td>";
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

        <div class="card mt-4 border-white border-3 bg-dark text-white">
            <div class="card-body">
                <h2 class="text-center">Contributing Projects</h2>
                <div class="table-responsive-lg mt-4">
                    <table class="table table-bordered table-hover table-dark table-lg bg-dark">
                        <thead>
                            <tr>
                                <th class="bg-secondary">Project ID</th>
                                <th class="bg-secondary">Project Name</th>
                                <!-- <th class="bg-secondary">Project Description</th> -->
                                <th class="bg-secondary">Start Date</th>
                                <th class="bg-secondary">End Date</th>
                                <th class="bg-secondary">View Project</th>
                                <th class="bg-secondary">Project Status</th>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM contributors WHERE userName = '$username';";
                            $result = mysqli_query($connection, $sql);
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . $row['pid'] . "</td>";

                                    $sql = "SELECT * FROM project WHERE pid = " . $row['pid'] . ";";
                                    $result1 = mysqli_query($connection, $sql);
                                    // var_dump($result1);
                                    if (mysqli_num_rows($result1) > 0) {
                                        // echo mysqli_num_rows($result1);
                                        while ($row1 = mysqli_fetch_assoc($result1)) {
                                            // var_dump($row1);
                                            echo "<td>" . $row1['pname'] . "</td>";
                                            echo "<td>" . $row1['sdate'] . "</td>";
                                            echo "<td>" . $row1['edate'] . "</td>";
                                            if ($row1['status'] == 'Completed')
                                                echo "<td class = 'text-center bg-success'>" . $row1['status'] . "</td>";
                                            else if ($row1['status'] == 'In Progress')
                                                echo "<td class = 'text-center bg-warning text-dark'>" . $row1['status'] . "</td>";
                                            else
                                                echo "<td class = 'text-center bg-warning text-dark'></td>";
                                        }
                                    }
                                    // echo "<td>" . $row['pdis'] . "</td>";
                            
                                    echo "<td><a class='btn btn-primary text-center d-block' href='./project-details.php?pid=" . $row['pid'] . "'>View</a></td>";
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







    <div id="footer"><?php include '../footer.php' ?></div>
</body>

</html>