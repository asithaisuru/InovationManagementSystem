<?php
require './Assets/Pages/dbconnection.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Web Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    
    
    
</head>

<body>
    <!-- Header -->
    
    <header class="bg-dark text-white py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="logo h3 mb-0">
            <img src="Assets\img\LogoWhite.png" alt="Logo" style="height: 40px; margin-right: 20px;">
                Eureka Innovation Management System</div>
            <nav>
                <ul class="nav">
                    <li class="nav-item"><a class="nav-link text-white" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="./sign-in.php">Sign In</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="#">Sign Up</a></li>
                </ul>
</nav>
        </div>
    </header>


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
            <h1 class="display-4">Make all your big projects possible with new features
                
            </h1>
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

         <!---Tabale section -->
        <section>

       <div class="container">
       <h2 class="table-headline">Roles and Benefits</h2>
        <div class="table-container">
      <table class="custom-table">
        <tr>
          <td class="role-column">Innovator</td>
          <td class="responsibility-column">
            <p><strong>Functions:</strong></p>
            <ul>
              <li>Submit new ideas for innovative products.</li>
              <li>Develop prototypes based on submitted ideas.</li>
              <li>Collaborate with sellers and buyers to refine products.</li>
            </ul>
          </td>
        </tr>
        <tr>
          <td class="role-column">Seller</td>
          <td class="responsibility-column">
            <p><strong>Functions:</strong></p>
            <ul>
              <li>List products for sale on the platform.</li>
              <li>Manage sales and orders efficiently.</li>
              <li>Provide prompt customer support for buyers.</li>
            </ul>
          </td>
        </tr>
        <tr>
          <td class="role-column">Buyer</td>
          <td class="responsibility-column">
            <p><strong>Functions:</strong></p>
            <ul>
              <li>Browse and search for products of interest.</li>
              <li>Make purchases securely through the platform.</li>
              <li>Offer feedback and reviews on purchased products.</li>
            </ul>
          </td>
        </tr>
      </table>
    </div>
  </div>
  </section>
 
    <!-- Recent Posts Section -->
    <section class="posts py-5">
        <div class="container">
            <h2 class="text-center">Recent Posts</h2>
            <div class="row mt-4">
                <?php
                $sql = "SELECT * FROM posts ORDER BY date DESC LIMIT 3;";
                $result = $connection->query($sql);

                // Check if there are results and fetch them
                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="col-md-4 mb-4">';
                    echo '<div class="card h-100">';
                        echo '<div class="card-body">';
                            echo '<h3 class="card-title">'. $row["title"].'</h3>';
                            echo '<p class="card-text">'. $row["content"].'</p>';
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
    <section class="see-more-section">
        <div class="container text-center mt-5">
            
            <!-- Link to the forum page -->
            <a href="Assets\Pages\Forum\forum.php" class="btn btn-primary btn-lg">See More</a>
           
        </div>
    </section>
<?php include 'Assets\Pages\footer.php';?>



</body>
</html>