<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<script src="js/carousel.js"></script>
<body class="text-center">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark text-center">
        <div class="container">
            <a class="navbar-brand" href="./supplier-dashboard.php"><img src="../../img/LogoWhite.png"
                    style="width:50px;height:50px;"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
    
    
    <div class="carousel">
        <div class="slides">
            <div class="slide"><img src="Assets/img/images11.jpg" alt="Image 1"></div>
            <div class="slide"><img src="Assets/img/images4.jpg" alt="Image 2"></div>
            <div class="slide"><img src="Assets/img/images5.jpg" alt="Image 3"></div>
        </div>
    </div>

    <section class="categories">
        <h2>Select Category</h2>
        <div class="category-buttons">
        <button><img src="Assets\img\icons\network.png" alt="Icon 1">Category 1</button>
        <button><img src="Assets\img\icons\project-management.png" alt="Icon 2">Category 2</button>
        <button><img src="Assets\img\icons\network.png" alt="Icon 3">Category 3</button>
        <button><img src="Assets\img\icons\network.png" alt="Icon 4">Category 4</button>
        </div>
    </section>
    <section class="posts">
    <h2>Recent Posts</h2>
    <div class="post">
        <h3>Post Title 1</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque id erat erat.</p>
    </div>
    <div class="post">
        <h3>Post Title 2</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque id erat erat.</p>
    </div>
    <div class="post">
        <h3>Post Title 3</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque id erat erat.</p>
    </div>
</section>
    <?php include('includes/footer.php') ?>
</body>
</html>
