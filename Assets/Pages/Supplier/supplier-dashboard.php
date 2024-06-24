<?php
session_start();
if (isset($_SESSION['username']) || isset($_SESSION['role'])) {
    $username = $_SESSION['username'];
    $role = $_SESSION['role'];
    if ($role != 'Supplier') {
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
    <title>Supplier - Dashboard</title>
    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {},
            Tawk_LoadStart = new Date();
        (function() {
            var s1 = document.createElement("script"),
                s0 = document.getElementsByTagName("script")[0];
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
    <?php include 'supplier-nav.php'; ?>
    <div class="container">
        <h1 class="text-center">Welcome to Supplier Dashboard</h1>
        <div class="row mt-4">
            <div class="col-lg-4 mb-2">
                <a href="./addproduct.php" class="btn btn-success d-block">Create Product</a>
            </div>
            <div class="col-lg-4 mb-2">
                <a href="./delete-prod.php" class="btn btn-danger d-block">Delete Product</a>
            </div>
            <div class="col-lg-4 mb-2">
                <a href="./edit-project.php" class="btn btn-primary d-block">Edit Product</a>
            </div>
        </div>
    </div>

</body>

</html>