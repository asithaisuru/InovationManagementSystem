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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IMS - Product</title>
</head>

<body class="bg-dark text-white">
    <?php
    if ($role == 'Supplier')
        include './supplier-nav.php';
    else if ($role == 'Innovator')
        include '../Innovator/innovator-nav.php';
    ?>

    <div class="container">
        <h2 class="text-center mb-5">Product View</h2>
        <?php
        $sql = "SELECT * FROM items WHERE prodId = '$_GET[prodId]'";
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
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        }
        ?>
    </div>
</body>

</html>