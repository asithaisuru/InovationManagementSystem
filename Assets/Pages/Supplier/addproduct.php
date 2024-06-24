<?php
session_start();
if (isset($_SESSION['username'])) {
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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IMS - Add Product</title>
</head>

<body class="bg-dark text-white">
    <?php include './supplier-nav.php'; ?>
    <div class="container mt-5">
        <div>
            <h2 class="text-center">Add Product</h2>
        </div>
        <div class="card bg-dark text-white border-white border-3">
            <div class="card-body">
                <form action="" method="POST">
                    <div class="form-floating mb-3 mt-3">
                        <input type="text" class="form-control" id="prodName" placeholder="Enter Product Name" name="prodName" required>
                        <label for="prodName" class="text-dark">Product Name</label>
                    </div>
                    <div class="form-floating mb-3 mt-3">
                        <input type="text" class="form-control" id="prodDis" placeholder="Enter Product Discription" name="prodDis" required>
                        <label for="prodDis" class="text-dark">Product Discription</label>
                    <div class="form-floating mb-3 mt-3">
                        <input type="text" class="form-control" id="prodDis" placeholder="Enter Product SKU" name="Enter Product SKU" required>
                        <label for="prodDis" class="text-dark">Product SKU</label>
                    </div>
                    <div class="form-floating mb-3 mt-3">
                        <input type="text" class="form-control" id="prodDis" placeholder="Enter Product DIS" name="Enter Product DIS" required>
                        <label for="prodDis" class="text-dark">Product Special Discount</label>
                    </div>
                    <div class="form-floating mb-3 mt-3">
                        <input type="text" class="form-control" id="prodDis" placeholder="supplierContactDetails" name="supplierContactDetails" required>
                        <label for="prodDis" class="text-dark">Product supplier Contact Details
                       
                    </label>
                       
                    </div>
                    <button type="submit" class="btn btn-success">Add Product</button>
                </form>

            </div>
        </div>


    </div>

    <?php include '../footer.php'; ?>
</body>

</html>