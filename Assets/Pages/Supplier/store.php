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

        <?php
        $sql = "SELECT * FROM products";
        $result = mysqli_query($connection, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="card border-3 border-white bg-dark text-white">';
                echo '<div class="card-body">';
                echo '<div class="row">';
                echo '<div class="col-md-6">';
                echo '<img src=' . $row["img"] . ' alt="Product Image" style="width: 100%; height: auto;">';
                echo '</div>';
                echo '<div class="col-md-6 my-auto">';
                //<!-- get the following data from db -->
                echo '<h2>' . $row["prodName"] . '</h2>';
                echo '<p>' . $row["prodDis"] . '</p>';
                echo '<p>' . $row["price"] . '</p>';
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