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
    <?php include 'supplier-nav.php'; ?>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Welcome to Supplier Dashboard, <?php echo htmlspecialchars($username); ?>!</h1>
        <div class="d-flex flex-column align-items-center">
            <a href="./addproduct.php" class="btn btn-success mb-2 w-50">Create Product</a>
            <a href="./delete-prod.php" class="btn btn-danger mb-2 w-50">Delete Product</a>
            <a href="./edit-product.php" class="btn btn-primary mb-2 w-50">Edit Product</a>
            <div class="card bg-dark text-white text-center mt-4 w-50">
                <div class="card-body">
                    <h5 class="card-title">Rating</h5>
                    <p class="card-text">0/5</p>
                    <div class="text-warning">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <p class="card-text">(0)</p>
                </div>
            </div>
        </div>

        <?php include '../footer.php'; ?>
    </div>

    <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script> -->
</body>

</html>