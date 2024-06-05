<?php session_start();
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $role = $_SESSION['role'];
    if ($role != 'Innovator') {
        echo "<script>window.location.href='../../../index.php';</script>";
        exit();
    }
} else { //
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
    $fname = $row['fname'];
    $lname = $row['lname'];
    $email = $row['email'];
}

$query = "SELECT * FROM profilePic WHERE userName = '$viewUserName'";
$result = mysqli_query($connection, $query);
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $viewerprofilePic = "../../img/profilePics/" . $row['image_url'];
    $_SESSION['image_url'] = $row['image_url'];
    // echo $_SESSION['image_url'];
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
</head>

<body class="bg-dark text-white">
    <?php include './innovator-nav.php'; ?>
    <div class="container">
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
    </div>
</body>

</html>