<?php
session_start();
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $role = $_SESSION['role'];
    if ($role != 'Supplier' && $role != 'Innovator' && $role != 'Admin') {
        echo "<script>window.location.href='../../../sign-in.php';</script>";
        exit();
    }
} else {
    ;
    echo "<script>window.location.href='../../../sign-in.php';</script>";
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
    else if ($role == 'Admin')
        include '../Admin/admin-nav.php';
    ?>

    <div class="container">
        <h2 class="text-center mb-5">Product View</h2>
        <?php
        if ($role == 'Admin') {
            echo '<div class="mt-5 row">';
            echo '<div class="col-lg-2">';
            echo '<h4>Approval : </h4>';
            echo '</div>';
            echo '<div class="col-lg-9">';
            echo '<form action="../Admin/approval.php" method="POST">';
            echo '<input type="hidden" name="prodId" value="'.$_GET["prodId"].'">';
            echo '<select name="status" id="status" class="form-select mb-3">';
            echo '<option value="Approved">Approved</option>';
            echo '<option value="Rejected">Rejected</option>';
            echo '</select>';
            echo '</div>';
            echo '<div class="col-lg-1">';
            echo '<button type="submit" class="btn btn-primary">Submit</button>';
            echo '</form>';
            echo '</div>';
            echo '</div>';
        }
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
                echo '<p>Seller : <a href="../Innovator/view-profile.php?userName=' . $row["userName"] . '">' . $row["userName"] . '</a></p>';
                
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