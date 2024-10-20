<?php
require_once '../Classes/Innovator.php';
session_start();

if (isset($_SESSION['username']) || isset($_SESSION['role'])) {
    $username = $_SESSION['username'];
    $role = $_SESSION['role'];
    if ($role != 'Supplier') {
        echo "<script>window.location.href='../../../sign-in.php';</script>";
        exit();
    }
} else {
    echo "<script>window.location.href='../../../sign-in.php';</script>";
    exit();
}

$innovator = new Innovator($username, "");
include '../dbconnection.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {},
            Tawk_LoadStart = new Date();
        (function () {
            var s1 = document.createElement("script"),
                s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/664344a19a809f19fb30bb2f/1htrc868i';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
    <!--End of Tawk.to Script-->
</head>

<body class=" bg-dark text-white">
    <?php include 'supplier-nav.php'; ?>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Welcome to Supplier Dashboard, <?php echo htmlspecialchars($username); ?>!</h1>
        <div class="row">
            <div class="col-lg-3 mb-3">
                <a href="./addproduct.php" class="btn btn-success mb-3 w-100">Add Product</a>
                <div class="card bg-dark text-white text-center w-100 border-white">
                    <div class="card-body">
                        <div class="text-center">
                            <div class="ratings">
                                <?php
                                $ratingCount = 0;
                                $ratingvalueCount = 0;
                                $maxRating = 5;

                                $result = $innovator->viewProfileGetUserRatings($connection, $username);
                                if ($result && mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $ratingvalueCount += $row['rating'];
                                        $ratingCount++;
                                    }
                                }
                                if ($ratingCount == 0) {
                                    $rating = 0;
                                } else {
                                    $rating = $ratingvalueCount / $ratingCount;
                                }
                                $filledStars = floor($rating);
                                $halfStar = ($rating - $filledStars) >= 0.5;
                                $emptyStars = $maxRating - $filledStars - ($halfStar ? 1 : 0);
                                echo '<h2>My Ratings</h2>';
                                echo '<span class="mt-1">' . $rating . '/' . $maxRating . '</span><br>';
                                // Filled stars
                                for ($i = 0; $i < $filledStars; $i++) {
                                    echo '<i class="fas fa-star"></i>';
                                }

                                // Half star
                                if ($halfStar) {
                                    echo '<i class="fas fa-star-half-alt"></i>';
                                }

                                // Empty stars
                                for ($i = 0; $i < $emptyStars; $i++) {
                                    echo '<i class="far fa-star"></i>';
                                }
                                echo '<p>(' . $ratingCount . ')</p>';
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="card border-white border-3 bg-dark text-white">
                    <div class="card-body">
                        <h2 class="text-center">Contributing Projects</h2>
                        <div class="table-responsive-lg">
                            <table class="table table-bordered table-hover table-dark table-lg bg-dark">
                                <thead>
                                    <tr>
                                        <th class="bg-secondary">Project ID</th>
                                        <th class="bg-secondary">Project Name</th>
                                        <!-- <th class="bg-secondary">Project Description</th> -->
                                        <th class="bg-secondary">Start Date</th>
                                        <th class="bg-secondary">End Date</th>
                                        <th class="bg-secondary">Project Status</th>
                                        <th class="bg-secondary">View Project</th>
                                </thead>
                                <tbody>
                                    <?php
                                    $result = $innovator->getContributorsWithUsername($connection, $username);
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<tr>";
                                            echo "<td>" . $row['pid'] . "</td>";

                                            $result1 = $innovator->getProjectDetails($connection, $row['pid']);
                                            if (mysqli_num_rows($result1) > 0) {
                                                while ($row1 = mysqli_fetch_assoc($result1)) {
                                                    echo "<td>" . $row1['pname'] . "</td>";
                                                    echo "<td>" . $row1['sdate'] . "</td>";
                                                    echo "<td>" . $row1['edate'] . "</td>";
                                                    if ($row1['status'] == 'Completed')
                                                        echo "<td class = 'text-center bg-success text-white'>" . $row1['status'] . "</td>";
                                                    else if ($row1['status'] == 'In Progress')
                                                        echo "<td class = 'text-center bg-warning text-dark text-white'>" . $row1['status'] . "</td>";
                                                    else
                                                        echo "<td class = 'text-center bg-warning text-dark'></td>";
                                                }
                                            }
                                            echo "<td><a class='btn btn-primary text-center d-block' href='../Innovator/project-details.php?pid=" . $row['pid'] . "'>View</a></td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='6' class='text-center'>No records found</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- <div class="container mt-5">
        <h1 class="text-center mb-4">Welcome to Supplier Dashboard, <?php echo htmlspecialchars($username); ?>!</h1>
        <div class="d-flex flex-column align-items-center">
            <a href="./addproduct.php" class="btn btn-success mb-2 w-50">Add Product</a>
            <a href="./delete-prod.php" class="btn btn-danger mb-2 w-50">Delete Product</a>
            <a href="./edit-product.php" class="btn btn-primary mb-2 w-50">Edit Product</a>
            <div class="card bg-dark text-white text-center mt-4 w-50">
                <div class="card-body">
                    <h5 class="card-title">Rating</h5>
                    <p class="card-text">0/5</p>
                    <div class="text-warning">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <p class="card-text">(0)</p>
                </div>
            </div>
        </div> -->

    <?php include '../footer.php'; ?>
    </div>

    <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script> -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            var ratedIndex = -1;

            $('.fa-star').on('click', function () {
                ratedIndex = parseInt($(this).data('index'));
                $('#rating-value').val(ratedIndex + 1);
                updateStars();
            });

            $('.fa-star').mouseover(function () {
                resetStars();
                var currentIndex = parseInt($(this).data('index'));
                setStars(currentIndex);
            });

            $('.fa-star').mouseleave(function () {
                resetStars();
                if (ratedIndex != -1) {
                    setStars(ratedIndex);
                }
            });

            function setStars(max) {
                for (var i = 0; i <= max; i++) {
                    $('.fa-star[data-index="' + i + '"]').addClass('checked');
                }
            }

            function resetStars() {
                $('.fa-star').removeClass('checked');
            }

            function updateStars() {
                resetStars();
                setStars(ratedIndex);
            }
        });
    </script>
</body>

</html>