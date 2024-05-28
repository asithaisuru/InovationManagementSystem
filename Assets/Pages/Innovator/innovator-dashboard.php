<?php
session_start();
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
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
                    <div class="col-lg-2 mb-2">
                        <a href="./project-creation.php" class="btn btn-success d-block">Create Project</a>
                    </div>
                    <div class="col-lg-2 mb-2">
                        <a href="#" class="btn btn-danger d-block">Remove Project</a>
                    </div>
                    <div class="col-lg-2 mb-2">
                        <a href="./edit-project.php" class="btn btn-primary d-block">Edit Project</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4 border-white border-3 bg-dark text-white">
            <div class="card-body">
                <h2 class="text-center">Your Projects</h2>
                <div class="table-responsive-lg mt-4">
                    <table class="table table-bordered table-hover table-dark table-lg bg-dark">
                        <thead>
                            <tr>
                                <th class="bg-secondary">Project ID</th>
                                <th class="bg-secondary">Project Name</th>
                                <th class="bg-secondary">Project Description</th>
                                <th class="bg-secondary">Start Date</th>
                                <th class="bg-secondary">End Date</th>
                        </thead>
                        <tbody>
                            <?php
                            // $sql = "SELECT * FROM projects WHERE createby='$username'";
                            // $result = mysqli_query($connection, $sql);
                            // if (mysqli_num_rows($result) > 0) {
                            //     while ($row = mysqli_fetch_assoc($result)) {
                            //         echo "<tr>";
                            //         echo "<td>" . $row['pid'] . "</td>";
                            //         echo "<td>" . $row['pname'] . "</td>";
                            //         echo "<td>" . $row['pdis'] . "</td>";
                            //         echo "<td>" . $row['startdate'] . "</td>";
                            //         echo "<td>" . $row['enddate'] . "</td>";
                            //         echo "</tr>";
                            //     }
                            // } else 
                            {
                                echo "<tr><td colspan='5' class='text-center'>No records found</td></tr>";
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