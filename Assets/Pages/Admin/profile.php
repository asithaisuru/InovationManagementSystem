<?php
session_start();
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    // header("Location: ../../../index.php");
    echo "<script>window.location.href='../../../sign-in.php';</script>";
    exit();
}
include '../dbconnection.php';
$query = "SELECT * FROM users WHERE userName = '$username'";
$result = mysqli_query($connection, $query);
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $fname = $row['fname'];
    $lname = $row['lname'];
    $email = $row['email'];
}
$query = "SELECT * FROM profilePic WHERE userName = '$username'";
$result = mysqli_query($connection, $query);
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $profilePic = "../../img/profilePics/" . $row['image_url'];
    $_SESSION['image_url'] = $row['image_url'];
    // echo $_SESSION['image_url'];
} else {
    $profilePic = "https://img.freepik.com/free-vector/blue-circle-with-white-user_78370-4707.jpg?t=st=1716576375~exp=1716579975~hmac=be6ca419460bee7ca7e72244b5462a3ce71eff32f244d69b7646c4e984e6f4ee&w=740";

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->
    <!-- End of Bootstrap -->
    <title>Profile Editor</title>
</head>
<body class="bg-dark text-white">
    <?php
    if ($_SESSION['role'] == "Admin" || $_SESSION['role'] == "Moderator") {
        include './admin-nav.php';
    } else if ($_SESSION['role'] == "Innovator") {
        include '../Innovator/innovator-nav.php';
    } else if ($_SESSION['role'] == "Supplier") {
        include '../Supplier/supplier-nav.php';
    } else if ($_SESSION['role'] == "Buyer") {
        include '../Buyer/buyer-nav.php';
    }
     echo '<div class="container">'; ?>
        <?php
        $status = isset($_GET['status']) ? htmlspecialchars($_GET['status']) : "";
        $msg = isset($_GET['msg']) ? htmlspecialchars($_GET['msg']) : "";
        if ($status == "success") {
            echo '<div class="container alert alert-success alert-dismissible fade show mt-3" role="alert">
                <strong>Success!</strong> ' . $msg . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        } else if ($status == "error") {
            echo '<div class="container alert alert-danger alert-dismissible fade show mt-3" role="alert">
                <strong>ERROR!!</strong> ' . $msg . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
        ?>
        <h1 class="text-center mt-3 mb-3">Profile Editor</h1>
        <div class="row">
            <div class="col-lg-6 mb-2">
                <div class="card bg-dark border-3 border-white">
                    <div class="card-header">
                        <h3 class="text-white">Update Profile Picture</h3>
                    </div>
                    <img class="card-img-top" src=<?php echo $profilePic ?> alt="Card image" style="width:100%">
                    <div class="card-body">
                        <form action="../upload.php?un=<?php echo $username ?>" method="POST"
                            enctype="multipart/form-data">
                            <div class="form-group mt-3">
                                <input type="file" class="form-control" name="profile-pic" id="profile-pic">
                                <pre
                                    class="text-white"><span class="text-danger">* </span>Best if photo in 1:1 ratio</pre>
                            </div>
                            <div class="mt-4 mb-4 ms-auto" style="width: 200px;">
                                <button type="submit" class="btn btn-primary" value="Upload" name="submit">Update
                                    Image</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card bg-dark border-3 border-white">
                    <div class="card-header">
                        <h3 class="text-white">Update Personal Information</h3>
                    </div>
                    <div class="card-body">
                        <form action="profile.php" method="POST">
                            <fieldset>
                                <legend class="text-white">Persenal info:</legend>
                                <div class="form-floating mb-3 mt-3">
                                    <input type="text" class="form-control" id="username" placeholder="Enter Username"
                                        name="username" value="<?php echo $username ?>" disabled>
                                    <label for="username">Username</label>
                                </div>
                                <div class="form-floating mb-3 mt-3">
                                    <input type="text" class="form-control" id="fname" placeholder="Enter First Name"
                                        name="fname" value="<?php echo $fname ?>">
                                    <label for="fname">First Name</label>
                                </div>
                                <div class="form-floating mb-3 mt-3">
                                    <input type="text" class="form-control" id="lname" placeholder="Enter Last Name"
                                        name="lname" value="<?php echo $lname ?>">
                                    <label for="lname">Last Name</label>
                                </div>
                                <div class="form-floating mb-3 mt-3">
                                    <input type="text" class="form-control" id="email" placeholder="Enter Email"
                                        name="email" value="<?php echo $email ?>">
                                    <label for="lname">Email</label>
                                </div>
                                <div class="mb-3 ms-auto" style="width: 200px;">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </fieldset>
                        </form>
                        <?php if ($_SESSION['role'] != "Admin"): ?>
                            <form id="skill-form" action="skill_update.php" method="POST">
                                <fieldset>
                                    <legend class="text-white">Skills:</legend>
                                    <div id="selected-skills" class="list-group-item list-group-item-action">
                                        <?php
                                        $sql = "SELECT * FROM user_skills WHERE userName = '$username'";
                                        $result1 = mysqli_query($connection, $sql);
                                        if (mysqli_num_rows($result1) > 0) {
                                            while ($row1 = mysqli_fetch_assoc($result1)) {
                                                echo "<span class='text-white badge bg-secondary me-2 mb-2' id='skill-" . $row1['id'] . "'>";
                                                echo $row1['skill'];
                                                echo " <button type='button' class='btn btn-danger btn-sm ms-2 delete-skill' data-id='" . $row1['id'] . "'>X</button>";
                                                echo "</span>";
                                            }
                                        }
                                        ?>
                                    </div>
                                    <div class="mb-3">
                                        <div id="selected-skills" class="mb-3">
                                            <div class="form-floating mb-3 mt-3">
                                                <input type="text" class="form-control" id="skill-input" name="skill-input"
                                                    placeholder="Enter Skill">
                                                <label for="skill-input">Skilled languages</label>
                                            </div>
                                            <div id="suggestions" class="list-group mt-1"></div>
                                        </div>
                                        <div class="mb-3 ms-auto" style="width: 200px;">
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                            <script>
                                $(document).ready(function () {
                                    $('.delete-skill').on('click', function () {
                                        var skillId = $(this).data('id');
                                        var skillElement = $('#skill-' + skillId);

                                        $.ajax({
                                            url: './delete_skill.php',
                                            type: 'POST',
                                            data: { "id": skillId },
                                            success: function (response) {
                                                if (response.trim() === "success") {
                                                    console.log("Skill deletion successful");
                                                    //  alert("Skill removed succesfully!");
                                                    skillElement.remove();
                                                } else {
                                                    console.log("Unexpected response:", response);
                                                    alert('Error deleting skill.');
                                                }
                                            },
                                            error: function () {
                                                alert('Error deleting skill.');
                                            }
                                        });
                                    });
                                });
                            </script>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
        <?php include '../footer.php'; ?>
    </div>
</body>
</html>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newfname = mysqli_real_escape_string($connection, $_POST['fname']);
    $newlname = mysqli_real_escape_string($connection, $_POST['lname']);
    $newemail = mysqli_real_escape_string($connection, $_POST['email']);

    $selectedSkills = isset($_POST['skills']) ? $_POST['skills'] : [];

    if ($newfname == $fname && $newlname == $lname && $newemail == $email) {
        echo '<div class="alert alert-warning alert-dismissible fade show mt-2" role="alert">
        <strong>Warning!</strong> Nothing Changed. Please Change the fields to update.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    } else {
        $query = "UPDATE users SET fname = '$newfname', lname = '$newlname', email = '$newemail' WHERE userName = '$username'";
        mysqli_query($connection, $query);
        if (mysqli_query($connection, $query)) {
            $ms = "Personal Infromation updated successfully.";
            echo '<script>
                    window.location.href = "profile.php?status=success&msg=' . $ms . '";
                </script>';
        } else {
            $ms = "Error updating profile." . mysqli_error($connection);
            echo '<script>
                    window.location.href = "profile.php?status=error&msg=' . $ms . '";
                </script>';
        }
    }
}
?>