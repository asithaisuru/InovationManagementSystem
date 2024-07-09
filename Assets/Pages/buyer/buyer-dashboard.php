<?php
session_start();
if (isset($_SESSION['username']) || isset($_SESSION['role'])) {
    $username = $_SESSION['username'];
    $role = $_SESSION['role'];
    if ($role != 'Buyer') {
        echo "<script>window.location.href='../../../index.php';</script>";
        exit();
    }
} else {
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
    <title>Buyer - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
    <!--End of Tawk.to Script-->
</head>

<body class="bg-dark text-white">
    <?php include 'buyer-nav.php'; ?>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Welcome to Buyer Dashboard, <?php echo htmlspecialchars($username); ?>!</h1>
        <div class="d-flex flex-column align-items-center">
            <a href="./view-products.php" class="btn btn-info mb-2 w-50">View Products</a>
            <a href="./order-history.php" class="btn btn-warning mb-2 w-50">Order History</a>
            <a href="./account-settings.php" class="btn btn-primary mb-2 w-50">Account Settings</a>
            <div class="card bg-dark text-white text-center mt-4 w-50">
                <div class="card-body">
                    <h5 class="card-title">Order Status</h5>
                    <p class="card-text">No recent orders</p>
                </div>
            </div>
        </div>

        <?php include '../footer.php'; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>
