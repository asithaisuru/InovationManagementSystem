<?php

require_once "../Classes/Innovator.php";
require_once "../Classes/Item.php";
session_start();
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $role = $_SESSION['role'];
    if ($role != 'Supplier' && $role != 'Innovator') {
        echo "<script>window.location.href='../../../sign-in.php';</script>";
        exit();
    }
} else {
    echo "<script>window.location.href='../../../sign-in.php';</script>";
    exit();
}
include '../dbconnection.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IMS - Store</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body class="bg-dark text-white">
    <?php
    if ($role == 'Supplier')
        include './supplier-nav.php';
    else if ($role == 'Innovator')
        include '../Innovator/innovator-nav.php';
    ?>

    <div class="container mt-5">
        <h1 class="text-center mb-5">Welcome to the IMS Store</h1>

        <form method="GET" class="mb-5">
            <div class="input-group">
                <input type="text" name="nameFilter" id="nameFilter" class="form-control"
                    placeholder="Enter product name"
                    value="<?php echo isset($_GET['nameFilter']) ? $_GET['nameFilter'] : ''; ?>">
                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
            </div>
        </form>

        <div class="row">
            <?php
            $sql = "SELECT * FROM items WHERE status = 'Approved'";
            if (isset($_GET['nameFilter'])) {
                $nameFilter = $_GET['nameFilter'];
                $sql .= " AND prodName LIKE '%$nameFilter%'";
            }
            $item = new Item("", "", "", "", "", );
            $result = $item->sqlExecutor($connection, $sql);
            if ($result != null) {
                // $result = mysqli_query($connection, $sql);
                // if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="col-md-6 col-lg-4 mb-4">';
                    echo '<div class="card border-3 border-white bg-dark text-white h-100">';
                    echo '<img src="' . $row["prodImg"] . '" alt="Product Image" class="card-img-top" style="object-fit: cover; height: 250px;">';
                    echo '<div class="card-body d-flex flex-column">';
                    echo '<h2 class="card-title">' . $row["prodName"] . '</h2>';
                    echo '<p class="card-text">' . $row["prodDis"] . '</p>';
                    echo '<p class="card-text">Rs. ' . $row["prodPrice"] . '</p>';
                    echo '<div class="mt-auto">';
                    echo '<a class="btn btn-success" href="./view-prod.php?prodId=' . $row["prodId"] . '">View Product</a>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p class="text-center">No products found.</p>';
            }
            ?>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
</body>

<?php include '../footer.php'; ?>

</html>