<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- End of Bootstrap -->

    <title>IMS - ERROR</title>
</head>

<body class="bg-dark text-white">
    <div class="container mt-5">
        <div class="card p-4 bg-dark border-white border-3">
            <div class="mt-2 p-3 bg-primary text-white rounded">
                <img class="card-img-top mx-auto d-block" src="../img/LogoWhite.png" alt="Logo"
                    style="width:150px;height:150px;">
                <div class="my-3">
                    <h1 class="text-center">Innovation Management System</h1>
                    <p class="text-center display-6"><small>Step into the new world</small></p>
                </div>
                <hr>
                <h1 class="display-3 text-white text-center">Error</h1>
                <h3 class="text-center"><?php echo $_GET['msj'] ?></h3>
            </div>
            
        </div>
    </div>
    <div>
        <footer class="bg-dark text-white">
            <div class="container py-4">
                <div class="row">
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
        </footer>
    </div>
</body>

</html>