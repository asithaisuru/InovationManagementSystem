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
    echo "<script>window.location.href='../../../index.php';</script>";
    exit();
}

// Include the database connection file
include "../dbconnection.php";

// Check if connection is successful

$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['prodid'])) {
    $prodId = mysqli_real_escape_string($connection, $_POST['prodid']);
    $sql = "SELECT * FROM items WHERE userName = '$username' AND prodId = '$prodId'";
    $result = mysqli_query($connection, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $prodName = $row['prodName'];
        $prodDis = $row['prodDis'];
        $prodPrice = $row['prodPrice'];
        $prodImg = $row['prodImg'];
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['prodName'], $_POST['prodDis'], $_POST['prodPrice'])) {
    $prodId = mysqli_real_escape_string($connection, $_POST['prodid']);
    $prodName = mysqli_real_escape_string($connection, $_POST['prodName']);
    $prodDis = mysqli_real_escape_string($connection, $_POST['prodDis']);
    $prodPrice = mysqli_real_escape_string($connection, $_POST['prodPrice']);
    $prodImg = $row['prodImg'];

    if (isset($_FILES['prodImage']) && $_FILES['prodImage']['error'] == 0) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true); // Create the directory if it doesn't exist
        }
        $target_file = $target_dir . basename($_FILES["prodImage"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is an actual image or fake image
        $check = getimagesize($_FILES["prodImage"]["tmp_name"]);
        if ($check !== false) {
            if (move_uploaded_file($_FILES["prodImage"]["tmp_name"], $target_file)) {
                $prodImg = $target_file;
            } else {
                echo "Sorry, there was an error uploading your file.";
                exit();
            }
        } else {
            echo "File is not an image.";
            exit();
        }
    }

    $sql = "UPDATE items SET prodName = '$prodName', prodDis = '$prodDis', prodPrice = '$prodPrice', prodImg = '$prodImg' WHERE prodId = '$prodId' AND userName = '$username'";
    if (mysqli_query($connection, $sql)) {
        $successMessage = "Product updated successfully.";
    } else {
        echo "Error updating product: " . mysqli_error($connection);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IMS - Edit Product</title>
</head>

<body class="bg-dark text-white">
    <?php include './supplier-nav.php'; ?>
    <div class="container mt-5">
        <div>
            <h2 class="text-center">Edit product</h2>
            <?php if ($successMessage): ?>
            <div class="alert alert-success">
                <?php echo $successMessage; ?>
            </div>
            <?php endif; ?>
            <div class="card mt-4 border-white border-3 bg-dark text-white">
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="form-floating mb-3 mt-3">
                            <select class="form-select mt-3" required name="prodid" id="pid"
                                onchange="this.form.submit()">
                                <?php
                                $sql = "SELECT * FROM items WHERE userName = '$username';";
                                $result = mysqli_query($connection, $sql);
                                echo "<option disabled selected></option>";
                                if ($result && mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<option value='" . $row['prodId'] . "'>" . $row['prodId'] . " - " . $row['prodName'] . "</option>";
                                    }
                                } else {
                                    echo "<option disabled>--Products not found--</option>";
                                }
                                ?>
                            </select>
                            <label for="pid">Select Product</label>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mt-4 border-white border-3 bg-dark text-white">
                <div class="card-body">
                    <form action="edit-product.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="prodid" value="<?php echo isset($prodId) ? $prodId : ''; ?>">
                        <div class="form-floating mb-3 mt-4 ms-3 me-3">
                            <input type="text" class="form-control" id="prodName" placeholder="Enter Product Name"
                                name="prodName" value="<?php echo isset($prodName) ? $prodName : ''; ?>" required>
                            <label for="prodName" class="text-dark">Edit Product Name</label>
                        </div>
                        <div class="form-floating mb-3 mt-4 ms-3 me-3">
                            <input type="text" class="form-control" id="prodDis" placeholder="Enter Product Description"
                                name="prodDis" value="<?php echo isset($prodDis) ? $prodDis : ''; ?>" required>
                            <label for="prodDis" class="text-dark">Edit Product Description</label>
                        </div>
                        <div class="form-floating mb-3 mt-4 ms-3 me-3">
                            <input type="text" class="form-control" id="prodPrice" placeholder="Product Price"
                                name="prodPrice" value="<?php echo isset($prodPrice) ? $prodPrice : ''; ?>" required>
                            <label for="prodPrice" class="text-dark">Edit Product Price</label>
                        </div>
                        <div class="form-floating mb-3 mt-4 ms-3 me-3">
                            <input type="file" class="form-control" id="prodImage" name="prodImage">
                            <label for="prodImage" class="text-dark">Edit Product Image</label>
                        </div>
                        <div class="form-floating mb-3 mt-4 ms-3 me-3">
                            <button type="submit" class="btn btn-primary">Update Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>