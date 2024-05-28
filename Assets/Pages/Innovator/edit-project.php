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
    <title>IMS - Edit Projects</title>
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
    <?php include '../Innovator/innovator-nav.php'; ?>

    <div class="container mt-5 bg-dark">
        <h2 class="text-center">Edit Project</h2>
        <div class="card bg-dark border-3 border-white mt-4">
            <div class="card-body">
                <div class="form-floating mb-3 mt-3">
                    <select class="form-select mt-3" required name="pID" id="pID">
                        <?php 
                            // $sql = "SELECT * FROM projects WHERE createby='$username'";
                            // $result = mysqli_query($connection, $sql);
                            // if (mysqli_num_rows($result) > 0) {
                            //     while ($row = mysqli_fetch_assoc($result)) {
                            //         echo "<option>" . $row['pid'] . "</option>";
                            //     }
                            // } else 
                            {
                                echo "<option disabled>--Projects not found--</option>";
                            }
                        ?>
                        <!-- <option value="Innovator">Innovator</option>
                        <option value="Supplier">Supplier</option>
                        <option value="Lawyer">Lawyer</option>
                        <option value="Marketing Manager">Marketing Manager</option> -->
                    </select>
                    <label for="pID">Select Project</label>
                </div>
            </div>
        </div>
    </div>

</body>

</html>