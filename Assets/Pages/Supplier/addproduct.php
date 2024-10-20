<?php
session_start();
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $role = $_SESSION['role'];
    if ($role != 'Supplier') {
        echo "<script>window.location.href='../../../sign-in.php';</script>";
        exit();
    }
} else {
    // header("Location: ../../../sign-in.php");
    echo "<script>window.location.href='../../../sign-in.php';</script>";
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
                <form action="add_product.php" method="POST" enctype="multipart/form-data">

                    <div class="form-floating mb-3 mt-3">
                        <input type="text" class="form-control" id="prodName" placeholder="Enter Product Name"
                            name="prodName" required>
                        <label for="prodName" class="text-dark">Product Name</label>
                    </div>
                    <div class="form-floating mb-3 mt-3">
                        <input type="text" class="form-control" id="prodDis" placeholder="Enter Product Discription"
                            name="prodDis" required>
                        <label for="prodDis" class="text-dark">Product Discription</label>
                        <div class="form-floating mb-3 mt-3">


                            <div class="form-floating mb-3 mt-3">
                                <input type="text" class="form-control" id="prodDis"
                                    placeholder="supplierContactDetails" name="prodPrice" required>
                                <label for="prodPrice" class="text-dark">Product Price
                                </label>
                            </div>
                            <div class="form-floating mb-3 mt-3">
                                <input type="file" class="form-control" id="prodImage" name="prodImage" required>
                                <label for="prodImage" class="text-dark">Upload Product Image</label>
                            </div>

                            <button type="submit" class="btn btn-success">Add Product</button>
                        </div>
                </form>

            </div>
        </div>


    </div>

    <?php include '../footer.php'; ?>
</body>

</html>