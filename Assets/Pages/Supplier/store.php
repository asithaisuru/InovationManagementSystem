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

        <div class="row" id="product-container">
            <!-- Products will be loaded here -->
        </div>

        <div class="text-center" id="LoadMoreButton">
            <button class="btn btn-primary" id="load-more" data-page="1">Load More</button>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
    <!-- jQuery (required for AJAX) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
    $(document).ready(function() {
        // Initial load of products
        loadProducts(1);

        // Load more products on button click
        $('#load-more').click(function() {
            let nextPage = $(this).data('page');
            loadProducts(nextPage);
        });

        function loadProducts(page) {
            const nameFilter = $('#nameFilter').val();
            $.ajax({
                url: './load-products.php',
                method: 'GET',
                data: {
                    page: page,
                    nameFilter: nameFilter
                },
                success: function(response) {
                    // Append the new products
                    $('#product-container').append(response);
                    // Update the data-page attribute to the next page
                    $('#load-more').data('page', page + 1);
                }
            });
        }
    });
    </script>
</body>

<?php include '../footer.php'; ?>

</html>