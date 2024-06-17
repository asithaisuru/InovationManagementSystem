<?php
session_start();
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $role = $_SESSION['role'];
    if ($role != 'Innovator' && $role != "Admin" && $role != "Moderator") {
        echo "<script>window.location.href='../../../index.php';</script>";
        exit();
    }
} else {
    header("Location: ../../../index.php");
    echo "<script>window.location.href='../../../index.php';</script>";
    exit();
}
include '../dbconnection.php';
$viewUserName = $_GET['userName'];
$query = "SELECT * FROM users WHERE userName = '$viewUserName'";
$result = mysqli_query($connection, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    if ($row['role'] == 'Admin' || $row['role'] == 'Moderator') {
        $msj = "User not found";
        echo "<script>window.location.href='../error.php?msj=$msj';</script>";
        exit();
    } else {
        $fname = $row['fname'];
        $lname = $row['lname'];
        $email = $row['email'];
    }

} else {
    $msj = "User not found";
    echo "<script>window.location.href='../error.php?msj=$msj';</script>";
    exit();
}

$query = "SELECT * FROM profilePic WHERE userName = '$viewUserName'";
$result = mysqli_query($connection, $query);
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $viewerprofilePic = "../../img/profilePics/" . $row['image_url'];
    $_SESSION['image_url'] = $row['image_url'];
} else {
    $viewerprofilePic = "https://img.freepik.com/free-vector/blue-circle-with-white-user_78370-4707.jpg?t=st=1716576375~exp=1716579975~hmac=be6ca419460bee7ca7e72244b5462a3ce71eff32f244d69b7646c4e984e6f4ee&w=740";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IMS - View Profile</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <style>
        .star-rating .fa-star {
            cursor: pointer;
            font-size: 2em;
            color: #ddd;
        }

        .star-rating .fa-star.checked {
            color: #f5c518;
        }
    </style>
</head>

<body class="bg-dark text-white">
    <?php
    if ($role == 'Admin' || $role == "Moderator")
        include '../Admin/admin-nav.php';
    elseif ($role == 'Innovator')
        include './innovator-nav.php'; ?>
    <div class="container">
        <?php
        $status = isset($_GET['ratingstatus']) ? htmlspecialchars($_GET['ratingstatus']) : "";
        if ($status == "success") {
            echo '<div class="container alert alert-success alert-dismissible fade show mt-3" role="alert">
                <strong>Success!</strong> Rating Added Successfully.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        } else if ($status == "error") {
            echo '<div class="container alert alert-danger alert-dismissible fade show mt-3" role="alert">
                <strong>ERROR!!</strong> Failed to Add Rating.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
        ?>

        <h2 class="text-center">View Profile</h2>
        <div class="row">
            <div class="col-lg-6">
                <div class="card mt-4 border-white border-3 bg-dark text-white">
                    <div class="card-body">
                        <h2>Profile Picture</h2>
                        <img src="<?php echo $viewerprofilePic; ?>" class="img-fluid" alt="Profile Picture">
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card mt-4 border-white border-3 bg-dark text-white">
                    <div class="card-body">
                        <h2>Personal Information</h2>
                        <div class="form-floating mb-3 mt-3">
                            <input type="text" class="form-control" id="username" placeholder="Enter Username"
                                name="username" value="<?php echo $viewUserName ?>" disabled>
                            <label for="username">Username</label>
                        </div>
                        <div class="form-floating mb-3 mt-3">
                            <input type="text" class="form-control" id="fname" placeholder="Enter First Name"
                                name="fname" value="<?php echo $fname ?>" disabled>
                            <label for="fname">First Name</label>
                        </div>
                        <div class="form-floating mb-3 mt-3">
                            <input type="text" class="form-control" id="lname" placeholder="Enter Last Name"
                                name="lname" value="<?php echo $lname ?>" disabled>
                            <label for="lname">Last Name</label>
                        </div>
                        <div class="form-floating mb-3 mt-3">
                            <input type="text" class="form-control" id="email" placeholder="Enter Email" name="email"
                                value="<?php echo $email ?>" disabled>
                            <label for="lname">Email</label>
                        </div>
                    </div>
                </div>
                <div class="card mt-4 border-white border-3 bg-dark text-white">
                    <div class="card-body">
                        <h2>Skills</h2>
                        <div></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card mt-4 border-white border-3 bg-dark text-white">
                    <div class="card-body">
                        <div class="text-center">
                            <div class="ratings">
                                <?php
                                $ratingCount = 0;
                                $ratingvalueCount = 0;
                                $maxRating = 5;

                                $query = "SELECT * FROM user_ratings WHERE userName = '$viewUserName'";
                                $result = mysqli_query($connection, $query);
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
                                echo '<h2>Rating<span class="ms-3 h5">' . $rating . '/' . $maxRating . '</span><br></h2>';
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
                        <?php if ($viewUserName != $username): ?>
                            <h2 class="mt-3">Rate User</h2>
                            <form action="submit-rating.php" method="POST">
                                <div class="star-rating">
                                    <i class="fa fa-star" data-index="0"></i>
                                    <i class="fa fa-star" data-index="1"></i>
                                    <i class="fa fa-star" data-index="2"></i>
                                    <i class="fa fa-star" data-index="3"></i>
                                    <i class="fa fa-star" data-index="4"></i>
                                </div>
                                <input type="hidden" name="rating" id="rating-value" value="0">
                                <input type="hidden" name="viewUserName" value="<?php echo $viewUserName; ?>">

                                <div class="form-floating mb-3 mt-3">
                                    <textarea class="form-control" id="review" placeholder="Enter Review" name="review"
                                        required></textarea>
                                    <label for="review" class="text-dark">Comment</label>
                                    <button type="submit" class="btn btn-primary mt-2">Submit Rating</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card mt-4 border-white border-3 bg-dark text-white">
                    <div class="card-body">
                        <h2 class="text-center">My Projects</h2>
                        <div class="mt-3">
                            <table class="table table-bordered table-hover table-dark table-lg bg-dark">
                                <thead>
                                    <tr>
                                        <th class="bg-secondary">Project ID</th>
                                        <th class="bg-secondary">Project Name</th>
                                        <th class="bg-secondary">Project Category</th>
                                        <th class="bg-secondary">Project Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM project WHERE userName = '$viewUserName';";
                                    $result = mysqli_query($connection, $sql);
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<tr>";
                                            echo "<td>" . $row['pid'] . "</td>";
                                            echo "<td>" . $row['pname'] . "</td>";
                                            echo "<td>" . $row['pcategory'] . "</td>";
                                            if ($row['status'] == 'Completed')
                                                echo "<td class='text-center bg-success'>" . $row['status'] . "</td>";
                                            else if ($row['status'] == 'In Progress')
                                                echo "<td class='text-center bg-warning text-white'>" . $row['status'] . "</td>";
                                            else
                                                echo "<td class='text-center bg-warning text-dark'></td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='4' class='text-center'>No records found</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card mt-4 border-white border-3 bg-dark text-white">
                    <div class="card-body">
                        <h2 class="text-center">Projects Contributed</h2>
                        <div class="mt-3">
                            <table class="table table-bordered table-hover table-dark table-lg bg-dark">
                                <thead>
                                    <tr>
                                        <th class="bg-secondary">Project ID</th>
                                        <th class="bg-secondary">Project Name</th>
                                        <th class="bg-secondary">Project Category</th>
                                        <th class="bg-secondary">Project Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM contributors WHERE userName = '$viewUserName';";
                                    $result = mysqli_query($connection, $sql);
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<tr>";
                                            echo "<td>" . $row['pid'] . "</td>";

                                            $sql = "SELECT * FROM project WHERE pid = " . $row['pid'] . ";";
                                            $result1 = mysqli_query($connection, $sql);
                                            if (mysqli_num_rows($result1) > 0) {
                                                while ($row1 = mysqli_fetch_assoc($result1)) {
                                                    echo "<td>" . $row1['pname'] . "</td>";
                                                    echo "<td>" . $row1['pcategory'] . "</td>";
                                                    if ($row1['status'] == 'Completed')
                                                        echo "<td class='text-center bg-success'>" . $row1['status'] . "</td>";
                                                    else if ($row1['status'] == 'In Progress')
                                                        echo "<td class='text-center bg-warning text-white'>" . $row1['status'] . "</td>";
                                                    else
                                                        echo "<td class='text-center bg-warning text-dark'></td>";
                                                }
                                            }
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='4' class='text-center'>No records found</td></tr>";
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
    <div id="footer">
        <?php include '../footer.php' ?>
    </div>

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