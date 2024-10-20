<?php
require_once "../Classes/Item.php";
include '../dbconnection.php';

// Set the number of products per page
$productsPerPage = 9;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $productsPerPage;

// Set up the base query
$sql = "SELECT * FROM items WHERE status = 'Approved'";

// Apply a name filter if provided
if (isset($_GET['nameFilter']) && !empty($_GET['nameFilter'])) {
    $nameFilter = $_GET['nameFilter'];
    $sql .= " AND prodName LIKE '%$nameFilter%'";
}

// Append limit for pagination
$sql .= " ORDER BY prodId DESC LIMIT $offset, $productsPerPage";

// Fetch the products
$item = new Item("", "", "", "", "", "");
$result = $item->sqlExecutor($connection, $sql);

if ($result != null) {
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
    echo '<p class="text-center">No more products found.</p>';
    echo '<script>document.getElementById("LoadMoreButton").style.display="none"</script>';
}
