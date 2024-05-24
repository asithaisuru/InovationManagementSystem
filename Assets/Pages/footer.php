<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->
    <!-- End of Bootstrap -->

    <title>Footer</title>
</head>

<body>
    
    <!-- <footer class="bg-dark text-white mt-5"> -->
        <div class="container py-4">
        <hr class="text-white border-3">
            <div class="row">
                <div class="col-md-4 text-center">
                    <h5>About Us</h5>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus lacinia odio vitae vestibulum
                        vestibulum.</p>
                </div>
                <div class="col-md-4 text-center">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white">Home</a></li>
                        <li><a href="#" class="text-white">About</a></li>
                        <li><a href="#" class="text-white">Services</a></li>
                        <li><a href="#" class="text-white">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-4 text-center">
                    <h5>Contact Us</h5>
                    <address>
                        1234 Street Name<br>
                        City, State, 12345<br>
                        <a href="mailto:info@example.com" class="text-white">info@example.com</a><br>
                        <a href="tel:+1234567890" class="text-white">+1 234 567 890</a>
                    </address>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col text-center">
                    <p>&copy;
                        <?php
                        $stYear = 2024;
                        $nowyear = date("Y");
                        if ($stYear == $nowyear) {
                            echo "$stYear";
                        } else {
                            echo "$stYear - $nowyear";
                        }
                        ?>
                        - Group 03. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    <!-- </footer> -->
</body>

</html>