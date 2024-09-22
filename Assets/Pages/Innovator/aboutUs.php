<?php
session_start();
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    // header("Location: ../../../index.php");
    // echo "<script>window.location.href='../../../sign-in.php';</script>";
    // exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
</head>

<body class="bg-dark text-white">
    <?php
    if (isset($_SESSION['username'])) {
        if ($_SESSION['role'] == "Admin") {
            include '../Admin/admin-nav.php';
        } else if ($_SESSION['role'] == "Innovator") {
            include './innovator-nav.php';
        } else if ($_SESSION['role'] == "Supplier") {
            include '../Supplier/supplier-nav.php';
        } else if ($_SESSION['role'] == "Buyer") {
            include '../buyer/buyer-nav.php';
        }
    } else {
        echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">';
        echo '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>';

        echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">';
        echo '<div class="py-3">';
        echo '<div class="ms-5 me-5 d-flex justify-content-between align-items-center mb-5">';
        echo '<div class="logo h3 mb-0 row">';
        echo '<div class="col-lg-1">';
        echo '<img src="..\..\..\Assets\img\LogoWhite.png" alt="Logo" style="height: 40px; margin-right: 20px;">';
        echo '</div>';
        echo '<div class="col-lg-11">';
        echo 'Eureka Innovation Management System';
        echo '</div>';
        echo '</div>';
        echo '<nav>';
        echo '<ul class="nav">';
        echo '<li class="nav-item"><a class="nav-link text-white" href="./aboutUs.php">About Us</a></li>';
        echo '<li class="nav-item"><a class="nav-link text-white" href="../../../index.php">Home</a></li>';
        echo '<li class="nav-item"><a class="nav-link text-white" href="../../../sign-in.php">Sign In</a></li>';
        echo '<li class="nav-item"><a class="nav-link text-white" href="../signup.php">Sign Up</a>';
        echo '</li>';
        echo '</ul>';
        echo '</nav>';
        echo '</div>';
    }
    ?>
    <div class="container">
        <div class="card bg-dark text-white border-3 border-white text-center mb-3">
            <div class="card-body">
                <h2>About Us</h2>
                <p>Our website is a platform for innovators to showcase their innovative ideas and projects. We
                    provide a
                    platform for innovators to connect with suppliers and investors. We also provide a platform for
                    suppliers to showcase their products and services to innovators. We also provide a platform for
                    investors to connect
                    with innovators and suppliers. Our website is a one-stop shop for innovators, suppliers, and
                    investors to
                    connect and collaborate on innovative projects. Our website is a platform for innovators to
                    showcase their
                    innovative ideas and projects. We provide a platform for innovators to connect with suppliers
                    and investors. We
                    also provide a platform for suppliers to showcase their products and services to innovators. We
                    also provide
                    a platform for investors to connect with innovators and suppliers. Our website is a one-stop
                    shop for
                    innovators, suppliers, and investors to connect and collaborate on innovative projects.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="card bg-dark text-white border-3 border-white text-center mb-3">
                    <div class="card-body">
                        <h2>Our Vision</h2>
                        <p>At Eureka, our vision is to create a dynamic platform for innovators to showcase their ideas
                            and projects. We connect innovators with suppliers and investors, facilitating collaboration
                            and growth. Our platform also allows suppliers to present their products and services, and
                            investors to find and support promising innovations. Eureka is your one-stop shop for
                            connecting and collaborating on innovative projects.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card bg-dark text-white border-3 border-white text-center mb-3">
                    <div class="card-body">
                        <h2>Our Mission</h2>
                        <p>Our mission is to create a platform where innovators can showcase their ideas and projects.
                            We connect innovators with suppliers and investors, facilitating collaboration and growth.
                            Suppliers can present their products and services, while investors can discover and support
                            promising innovations. Eureka is your one-stop shop for innovators, suppliers, and investors
                            to connect and collaborate on innovative projects.
                        </p>
                    </div>
                </div>
            </div>
        </div>


        <div class="card bg-dark text-white border-3 border-white text-center mb-3">
            <div class="card-body">
                <h2>Who We Are</h2>
                <p>We are a team of passionate innovators who are dedicated to creating a platform for innovators to
                    showcase
                    their innovative ideas and projects. We provide a platform for innovators to connect with suppliers
                    and
                    investors. We also provide a platform for suppliers to showcase their products and services to
                    innovators.
                    We also provide a platform for investors to connect with innovators and suppliers. Our website is a
                    one-stop
                    shop for innovators, suppliers, and investors to connect and collaborate on innovative projects. We
                    are a
                    team of passionate innovators who are dedicated to creating a platform for innovators to showcase
                    their
                    innovative ideas and projects. We provide a platform for innovators to connect with suppliers and
                    investors.
                    We also provide a platform for suppliers to showcase their products and services to innovators. We
                    also
                    provide a platform for investors to connect with innovators and suppliers. Our website is a one-stop
                    shop
                    for innovators, suppliers, and investors to connect and collaborate on innovative projects.
                </p>
            </div>
        </div>
        <div class="card bg-dark text-white border-3 border-white mb-3">
            <div class="card-body">
                <h2 class=" text-center">What We Offer</h2>
                <div class="row">
                    <div class="col-lg-2"></div>
                    <div class="col-lg-8">
                        <ul class="list-group">
                            <li class="list-group-item bg-dark text-white">Innovator Showcase: A platform
                                for innovators to showcase their ideas and projects.</li>
                            <li class="list-group-item bg-dark text-white">Connections: Innovators can
                                connect with suppliers and investors.</li>
                            <li class="list-group-item bg-dark text-white">Supplier Showcase: Suppliers
                                can present their products and services to innovators.</li>
                            <li class="list-group-item bg-dark text-white">Investor Connections: Investors
                                can connect with innovators and suppliers.</li>
                            <li class="list-group-item bg-dark text-white">Collaboration Hub: A one-stop
                                shop for innovators, suppliers, and investors to connect and collaborate on innovative
                                projects.
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-2"></div>
                </div>
            </div>
        </div>
        <div class="card bg-dark text-white border-3 border-white text-center mb-3">
            <div class="card-body">
                <h2>Our Values</h2>
                <p>Our values are innovation, collaboration, and excellence. We are committed to creating a platform
                    for
                    innovators to showcase their innovative ideas and projects. We provide a platform for innovators to
                    connect
                    with suppliers and investors. We also provide a platform for suppliers to showcase their products
                    and services
                    to innovators. We also provide a platform for investors to connect with innovators and suppliers.
                    Our
                    website
                    is a one-stop shop for innovators, suppliers, and investors to connect and collaborate on innovative
                    projects.
                    Our values are innovation, collaboration, and excellence. We are committed to creating a platform
                    for
                    innovators
                    to showcase their innovative ideas and projects. We provide a platform for innovators to connect
                    with
                    suppliers
                    and investors. We also provide a platform for suppliers to showcase their products and services to
                    innovators.
                    We also provide a platform for investors to connect with innovators and suppliers. Our website is a
                    one-stop
                    shop for innovators, suppliers, and investors to connect and collaborate on innovative projects.
                </p>
            </div>
        </div>
        <div class="card bg-dark text-white border-3 border-white text-center mb-3">
            <div class="card-body">
                <h2>Join Us on Our Journey to Innovation!</h2>
                <p>Join us on our journey to innovation! We are a team of passionate innovators who are dedicated to
                    creating a
                    platform for innovators to showcase their innovative ideas and projects. We provide a platform for
                    innovators
                    to connect with suppliers and investors. We also provide a platform for suppliers to showcase their
                    products
                    and services to innovators. We also provide a platform for investors to connect with innovators and
                    suppliers.
                    Our website is a one-stop shop for innovators, suppliers, and investors to connect and collaborate
                    on
                    innovative projects. Join us on our journey to innovation! We are a team of passionate innovators
                    who
                    are
                    dedicated to creating a platform for innovators to showcase their innovative ideas and projects. We
                    provide
                    a platform for innovators to connect with suppliers and investors. We also provide a platform for
                    suppliers
                    to showcase their products and services to innovators. We also provide a platform for investors to
                    connect
                    with innovators and suppliers. Our website is a one-stop shop for innovators, suppliers, and
                    investors
                    to
                    connect and collaborate on innovative projects.
                </p>
            </div>
        </div>
        <div class="card bg-dark text-white border-3 border-white text-center mb-3">
            <div class="card-body">
                <h2>Contact Us</h2>
                <p>If you have any questions or comments, please feel free to contact us at
                <address>
                    No:21, Colombo, Srilanka.<br>
                    <a href="mailto:info@example.com" class="text-white">Eureka@gmail.com</a><br>
                    <a href="tel:+1234567890" class="text-white">+45 222 3033</a>
                </address>
                </p>
            </div>
        </div>
    </div>
</body>
<?php include '../footer.php'; ?>

</html>