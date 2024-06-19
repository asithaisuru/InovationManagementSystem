<?php
session_start();
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $role = $_SESSION['role'];
    if ($role != 'Supplier' && $role != 'Innovator') {
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
    <title>IMS - Store</title>
</head>

<body class="bg-dark text-white">
    <?php
    if ($role == 'Supplier')
        include './supplier-nav.php';
    else if ($role == 'Innovator')
        include '../Innovator/innovator-nav.php';
    ?>

    <div class="container">
        <h1 class="text-center mb-5">Welcome to the IMS Store</h1>

        <form method="GET">
            <div class="row">
                <div class="col-lg-11">
                    <div class="mb-3">
                        <input type="text" name="nameFilter" id="nameFilter" class="form-control"
                            placeholder="Enter product name">
                    </div>
                </div>
                <div class="col-lg-1 mb-2">
                    <button type="submit" class="btn btn-primary text-center d-block"><i
                            class="fas fa-search"></i></button>
                </div>
            </div>
        </form>

        <?php
        $sql = "SELECT * FROM items";
        if (isset($_GET['nameFilter'])) {
            $nameFilter = $_GET['nameFilter'];
            $sql .= " WHERE prodName LIKE '%$nameFilter%'";
        }
        $result = mysqli_query($connection, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="card border-3 border-white bg-dark text-white mb-3">';
                echo '<div class="card-body">';
                echo '<div class="row">';
                echo '<div class="col-md-6">';
                echo '<img src=' . $row["prodImg"] . ' alt="Product Image" style="width: 100%; height: auto;">';
                echo '</div>';
                echo '<div class="col-md-6 my-auto">';
                //<!-- get the following data from db -->
                echo '<h2>' . $row["prodName"] . '</h2>';
                echo '<p>' . $row["prodDis"] . '</p>';
                echo '<p> Rs. ' . $row["prodPrice"] . '</p>';
                echo '<div class="text-end me-5">';
                echo '<a class="btn btn-success" href="./view-prod.php?prodId=' . $row["prodId"] . '">View Product</a>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        }
        ?>

    </div>
</body>

<?php include '../footer.php'; ?>

</html>