<?php
require './Assets/Pages/dbconnection.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Web Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body class="bg-dark text-white">
    <!-- Header -->

    <div class="py-3">
        <div class="ms-5 me-5 d-flex justify-content-between align-items-center">
            <div class="logo h3 mb-0">
                <img src="Assets\img\LogoWhite.png" alt="Logo" style="height: 40px; margin-right: 20px;">
                Eureka Innovation Management System
            </div>
            <nav>
                <ul class="nav">
                    <li class="nav-item"><a class="nav-link text-white" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="./sign-in.php">Sign In</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="./Assets/Pages/signup.php">Sign Up</a></li>
                </ul>
            </nav>
        </div>
    </div>



    <!-- Hero Section with Carousel Behind Search Bar -->
    <div class="hero text-center position-relative">
        <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
            <ol class="carousel-indicators">
                <li data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></li>
                <li data-bs-target="#heroCarousel" data-bs-slide-to="1"></li>
                <li data-bs-target="#heroCarousel" data-bs-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100" src="https://wallpaperaccess.com/full/2461288.jpg" alt="First slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="https://wallpaperaccess.com/full/2461292.jpg" alt="Second slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="https://wallpaperaccess.com/full/2461288.jpg" alt="Third slide">
                </div>
            </div>
            <a class="carousel-control-prev" href="#heroCarousel" role="button" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </a>
            <a class="carousel-control-next" href="#heroCarousel" role="button" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </a>
        </div>
    </div>


    <!-- Hero Section -->
    <section class="hero text-center py-5">
        <div class="container">
            <h1 class="display-4">Make all your big projects possible with new features</h1>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="categories py-5 bg-dark">
        <div class="container text-center">
            <h2 class="text-white">Explore Categories</h2>
            <div class="d-flex justify-content-center flex-wrap mt-4">
                <button class="btn btn-outline-light m-2 d-flex align-items-center"><i class="fas fa-pen-nib"></i><span class="text-white ms-2">Graphics & Design</span></button>
                <button class="btn btn-outline-light m-2 d-flex align-items-center"><img src="https://via.placeholder.com/32" class="mr-2" alt="Icon 2"><span class="text-white">Digital Marketing</span></button>
                <button class="btn btn-outline-light m-2 d-flex align-items-center"><img src="https://via.placeholder.com/32" class="mr-2" alt="Icon 3"><span class="text-white">Writing & Translation</span></button>
                <button class="btn btn-outline-light m-2 d-flex align-items-center"><img src="https://via.placeholder.com/32" class="mr-2" alt="Icon 4"><span class="text-white">Video & Animation</span></button>
            </div>
        </div>
    </section>

    <!-- Featured Services Section -->
    <section class="featured-services py-5">
        <div class="container">
            <h2 class="text-center">Featured Services</h2>
            <div class="row mt-4">
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img class="card-img-top" src="Assets/img/woman-office-exploring-statistics.jpg" alt="Service 1">
                        <div class="card-body">
                            <h3 class="card-title">Market Research and Analysis</h3>
                            
                            <p class="card-text">Gain insights into industry trends, competitors, and customer needs to identify opportunities and reduce risks.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img class="card-img-top" src="Assets\img\partnership-handshake-innovation-corporate-business-concept.jpg" alt="Service 2">
                        <div class="card-body">
                            <h3 class="card-title">Strategic Partnerships and Networking</h3>
                            <p class="card-text">Form key partnerships and collaborations to boost your innovation and business reach.</p>



</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img class="card-img-top" src="https://via.placeholder.com/350x150" alt="Service 3">
                        <div class="card-body">
                            <h3 class="card-title">Technology Scouting and Integration</h3>
                            <p class="card-text">Find and integrate cutting-edge technologies to boost your innovation</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!---Tabale section -->
    <section>
        <div class="container w-50">
            <h2 class="text-center mb-4">Roles and Benefits</h2>
            <div>
                <table class="table border-2 border-dark">
                    <tr>
                        <td class="text-center bg-primary text-white fw-bold align-middle rounded-start-4 fs-4">Innovator</td>
                        <td class="rounded-end-4">
                            <div class="ms-3">
                                <p><strong>Functions:</strong></p>
                                <ul>
                                    <li>Submit new ideas for innovative products.</li>
                                    <li>Develop prototypes based on submitted ideas.</li>
                                    <li>Collaborate with sellers and buyers to refine products.</li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center bg-primary text-white fw-bold align-middle rounded-start-4 fs-4">Seller</td>
                        <td class="rounded-end-4">
                            <div class="ms-3">
                                <p><strong>Functions:</strong></p>
                                <ul>
                                    <li>List products for sale on the platform.</li>
                                    <li>Manage sales and orders efficiently.</li>
                                    <li>Provide prompt customer support for buyers.</li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center bg-primary text-white fw-bold align-middle rounded-start-4 fs-4">Buyer</td>
                        <td class="rounded-end-4">
                            <div class="ms-3">
                                <p><strong>Functions:</strong></p>
                                <ul>
                                    <li>Browse and search for products of interest.</li>
                                    <li>Make purchases securely through the platform.</li>
                                    <li>Offer feedback and reviews on purchased products.</li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </section>

    <!-- Recent Posts Section -->
    <section class="posts py-5 bg-dark">
        <div class="container">
            <h2 class="text-center text-white">Recent Posts</h2>
            <div class="row mt-4">
                <?php
                $sql = "SELECT * FROM posts ORDER BY date DESC LIMIT 3;";
                $result = $connection->query($sql);

                // Check if there are results and fetch them
                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="col-md-12 mb-3">';
                        echo '<div class="card h-100 bg-dark text-white border-2 border-white">';
                        echo '<div class="card-body text-center">';
                        echo '<h3 class="card-title">' . $row["title"] . '</h3>';
                        echo '<p class="card-text">' . $row["content"] . '</p>';
                        echo '<p class="card-text text-secondary">' . $row["date"] . '</p>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';

                        // echo "id: " . $row["id"]. " - Title: " . $row["title"]. " - Date: " . $row["date"]. "<br>";
                    }
                } else {
                    echo "0 results";
                }
                ?>
            </div>
        </div>
    </section>
    <!-- See More Button Section -->
    <section>
        <div class="container text-center">
            <a href="Assets\Pages\Forum\forum.php" class="btn btn-primary btn-lg">See More</a>
        </div>
    </section>
    <?php include 'Assets\Pages\footer.php'; ?>



</body>

</html>