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
    <title>IMS - Delete Product</title>
</head>

<body class="bg-dark text-white">
    <?php include './supplier-nav.php'; ?>

    <div class="container">
        <?php
        $status = isset($_GET['projectdeletestatus']) ? htmlspecialchars($_GET['projectdeletestatus']) : "";
        if ($status == "success") {
            echo '<div class="container alert alert-success alert-dismissible fade show mt-3" role="alert">
                <strong>Success!</strong> Project Deleted Successfully.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        } else if ($status == "error") {
            echo '<div class="container alert alert-danger alert-dismissible fade show mt-3" role="alert">
                <strong>ERROR!!</strong> Failed to Delete Project.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
        ?>

        <h2 class="text-center">Delete Product</h2>
        <div class="card mt-4 border-white border-3 bg-dark text-white">
            <div class="card-body">
                <form action="delete-project.php" method="POST">
                    <div class="form-floating mb-3 mt-3">
                        <select class="form-select mt-3" required name="prodid" id="pid">
                            <?php
                            $sql = "SELECT * FROM items WHERE userName = '$username';";
                            $result = mysqli_query($connection, $sql);
                            echo "<option disabled selected></option>";
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value=" . $row['prodId'] . ">" . $row['prodId'] . " - " . $row['prodName'] . "</option>";
                                    if ($row['pid'] == htmlspecialchars($_GET['pid'])) {
                                        echo '<script>
                                            document.getElementById("pid").value = ' . htmlspecialchars($_GET['pid']) . ';
                                        </script>';
                                    }
                                }
                            } else {
                                echo "<option disabled>--Projects not found--</option>";
                            }
                            ?>
                        </select>
                        <label for="pid">Select Product</label>
                    </div>
                    <button type="submit" class="btn btn-danger">Delete Product</button>
                </form>

            </div>
        </div>
    </div>
    <?php include '../footer.php'; ?>
</body>

</html>