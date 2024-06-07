<?php
session_start();
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $role = $_SESSION['role'];
    if ($role != 'Admin' && $role != 'Moderator') {
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
    <title>IMS - Dashboard</title>
</head>

<body class="bg-dark text-white">

    <?php include 'admin-nav.php'; ?>

    <div class="container text-center mb-5">
        <div class="clock display-1" id="clock"><?php echo date('H:i:s'); ?></div>
        <div class="date display-6" id="date"><?php echo date('d-m-Y'); ?></div>
    </div>

    <script>
        function updateClock() {
            var now = new Date();
            var hours = now.getHours().toString().padStart(2, '0');
            var minutes = now.getMinutes().toString().padStart(2, '0');
            var seconds = now.getSeconds().toString().padStart(2, '0');
            var timeString = hours + ':' + minutes + ':' + seconds;
            document.getElementById('clock').textContent = timeString;
        }

        setInterval(updateClock, 1000);
        updateClock(); // Initial call to set the time immediately
    </script>

    <?php if ($_SESSION['role'] == "Admin"): ?>
        <div class="container text-center">
            <h1>IMS - Dashboard</h1>
            <!-- <p>This is the Admin Dashboard. You can create manage Admin profiles, projects</p> -->
        </div>

    <?php elseif ($_SESSION['role'] == "Moderator"): ?>
        <div class="container text-center">
            <h1>Moderator Dashboard</h1>
            <!-- <p>This is the Moderator Dashboard. You can manage projects and solve problems of coustomers.</p> -->
        </div>
    <?php endif; ?>

    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-4 mb-2">
                <div class="card bg-success border-3 border-white text-white text-center">
                    <div class="card-body">
                        <h3 class="card-title ">Total Projects</h3>
                        <h1 class="card-text">
                            <?php
                            $sql = "SELECT * FROM project";
                            $result = $connection->query($sql);
                            if ($result) {
                                echo $result->num_rows;
                            } else {
                                echo "Error executing query: " . $connection->error;
                            }
                            ?>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-2">
                <div class="card bg-primary border-3 border-white text-white text-center">
                    <div class="card-body">
                        <h3 class="card-title ">Total Users</h3>
                        <h1 class="card-text">
                            <?php
                            $sql = "SELECT * FROM users WHERE role!='Admin' AND role!='Moderator'";
                            $result = $connection->query($sql);
                            if ($result) {
                                echo $result->num_rows;
                            } else {
                                echo "Error executing query: " . $connection->error;
                            }
                            ?>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-2">
                <div class="card bg-info border-3 border-white text-white text-center">
                    <div class="card-body">
                        <h3 class="card-title ">Total Contributions</h3>
                        <h1 class="card-text">
                            <?php
                            $sql = "SELECT * FROM contributors";
                            $result = $connection->query($sql);
                            if ($result) {
                                echo $result->num_rows;
                            } else {
                                echo "Error executing query: " . $connection->error;
                            }
                            ?>
                        </h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4"></div>
            <div class="col-lg-4">
                <div class="card bg-warning border-3 border-white text-white text-center mt-4">
                    <div class="card-body">
                        <h3 class="card-title">Active Users</h3>
                        <div class="card-text">
                            <h1 class="card-text" id="activeUsers">
                                <?php
                                $sql = "SELECT * FROM users WHERE role!='Admin' AND role!='Moderator' AND active='1'";
                                $result = $connection->query($sql);
                                if ($result) {
                                    echo $result->num_rows;
                                } else {
                                    echo "Error executing query: " . $connection->error;
                                }
                                ?>
                            </h1>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-lg-4"></div>
        </div>
    </div>


    <div id="footer">
        <?php include '../footer.php' ?>
    </div>
</body>

</html>