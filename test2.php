<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Web Page</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <!-- Header -->
    <!-- <header class="bg-dark text-white py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="logo h3 mb-0">MyWebsite</div>
            <nav>
                <ul class="nav">
                    <li class="nav-item"><a class="nav-link text-white" href="#">Home</a></li>
                    <?php if (isset($_SESSION['username'])): ?>
                        <li class="nav-item"><a class="nav-link text-white" href="#">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link text-white" href="signin.php">Sign In</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="signup.php">Sign Up</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header> -->
    <?php include 'Assets\Pages\Innovator\innovator-nav.php';?>

    <!-- Hero Section with Carousel Behind Search Bar -->
<section class="hero bg-light text-center position-relative">
    <div id="heroCarousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#heroCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#heroCarousel" data-slide-to="1"></li>
            <li data-target="#heroCarousel" data-slide-to="2"></li>
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
        <a class="carousel-control-prev" href="#heroCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#heroCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <!-- <div class="container position-absolute w-100 h-100 d-flex flex-column justify-content-center align-items-center text-center" style="top: 0;">
        <h1 class="display-4">Find the perfect freelance services for your business</h1>
        <form class="form-inline justify-content-center mt-4 w-100">
            <input class="form-control mr-2 w-100" type="search" placeholder="Search for services" aria-label="Search">
            <button class="btn btn-primary" type="submit">Search</button>
        </form>
    </div> -->
</section>

    
    <!-- Hero Section -->
    <section class="hero bg-light text-center py-5">
        <div class="container">
            <h1 class="display-4">Find the perfect freelance services for your business</h1>
            <form class="form-inline justify-content-center mt-4">
                <input class="form-control mr-2 w-50" type="search" placeholder="Search for services" aria-label="Search">
                <button class="btn btn-primary" type="submit">Search</button>
            </form>
        </div>
    </section>
    
    <!-- Categories Section -->
    <section class="categories py-5">
        <div class="container text-center">
            <h2>Explore Categories</h2>
            <div class="d-flex justify-content-center flex-wrap mt-4">
                <button class="btn btn-outline-dark m-2 d-flex align-items-center"><img src="https://via.placeholder.com/32" class="mr-2" alt="Icon 1">Graphics & Design</button>
                <button class="btn btn-outline-dark m-2 d-flex align-items-center"><img src="https://via.placeholder.com/32" class="mr-2" alt="Icon 2">Digital Marketing</button>
                <button class="btn btn-outline-dark m-2 d-flex align-items-center"><img src="https://via.placeholder.com/32" class="mr-2" alt="Icon 3">Writing & Translation</button>
                <button class="btn btn-outline-dark m-2 d-flex align-items-center"><img src="https://via.placeholder.com/32" class="mr-2" alt="Icon 4">Video & Animation</button>
            </div>
        </div>
    </section>

    <!-- Featured Services Section -->
    <section class="featured-services py-5 bg-light">
        <div class="container">
            <h2 class="text-center">Featured Services</h2>
            <div class="row mt-4">
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img class="card-img-top" src="https://via.placeholder.com/350x150" alt="Service 1">
                        <div class="card-body">
                            <h3 class="card-title">Service Title 1</h3>
                            <p class="card-text">Description of the service provided by the freelancer.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img class="card-img-top" src="https://via.placeholder.com/350x150" alt="Service 2">
                        <div class="card-body">
                            <h3 class="card-title">Service Title 2</h3>
                            <p class="card-text">Description of the service provided by the freelancer.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img class="card-img-top" src="https://via.placeholder.com/350x150" alt="Service 3">
                        <div class="card-body">
                            <h3 class="card-title">Service Title 3</h3>
                            <p class="card-text">Description of the service provided by the freelancer.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Recent Posts Section -->
    <section class="posts py-5">
        <div class="container">
            <h2 class="text-center">Recent Posts</h2>
            <div class="row mt-4">
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h3 class="card-title">Post Title 1</h3>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque id erat erat.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h3 class="card-title">Post Title 2</h3>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque id erat erat.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h3 class="card-title">Post Title 3</h3>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque id erat erat.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
