<?php
session_start();
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    // header("Location: ../../../index.php");
    echo "<script>window.location.href='../../../index.php';</script>";
    exit();
}

if (isset($_SESSION["role"])) {
    if ($_SESSION["role"] == "Admin" || $_SESSION["role"] == "Moderator") {
    } else {
        echo "<script>window.location.href='../../../index.php';</script>";
        exit();
    }
} else {
    echo "<script>window.location.href='../../../index.php';</script>";
    exit();
}

include '../dbconnection.php';


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Dashboard</title>
</head>

<body class="bg-dark text-white border-white border-3">
    <?php include 'admin-nav.php'; ?>

    <?php if ($_SESSION['role'] != "Moderator"): ?>
        <div class="container mt-5">
            <h2 class="text-center">User Management</h2>
            <div class="card mt-4 border-white border-3 bg-dark text-white" id="add-user">
                <div class="card-body">
                    <h1 class="text-white text-center">Add Admin User</h1>

                    <?php
                    // echo "geterror<br>";
                    $status = isset($_GET['adduserstatus']) ? htmlspecialchars($_GET['adduserstatus']) : "";
                    $msg = isset($_GET['msg']) ? htmlspecialchars($_GET['msg']) : "";
                    // echo $status.'<br>';
                    // echo $msg.'<br>';
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

                    <form action="add_user.php" method="POST">
                        <div class="form-floating mb-3 mt-3">
                            <input type="text" class="form-control" id="username" placeholder="Enter Username"
                                name="username">
                            <label for="username" class="text-dark">Username</label>
                            <small class="text-secondary"><span class="text-danger">* </span>
                                <span data-bs-toggle="tooltip" data-bs-placement="bottom"
                                    title="!@#$%^&*()-=_+[]{}\|;:'&quot;,.<>?/" class="text-white"><kbd>Symbols</kbd></span>
                                and
                                <span data-bs-toggle="tooltip" data-bs-placement="bottom" title=".,:;!?'()[]{}"
                                    class="text-white"><kbd>Punctuation marks</kbd></span> are not allowed.
                            </small>
                        </div>
                        <div class="form-floating mb-3 mt-3">
                            <input type="text" class="form-control" id="fname" placeholder="Enter First Name" name="fname">
                            <label for=" fname" class="text-dark">First Name</label>
                        </div>
                        <div class="form-floating mb-3 mt-3">
                            <input type="text" class="form-control" id="lname" placeholder="Enter Last Name" name="lname">
                            <label for="lname" class="text-dark">Last Name</label>
                        </div>
                        <div class="form-floating mb-3 mt-3">
                            <input type="text" class="form-control" id="email" placeholder="Enter Email" name="email">
                            <label for="email" class="text-dark">Email</label>
                        </div>
                        <div class="form-floating mb-3 mt-3">
                            <select class="form-select mt-3" required name="role" id="role">
                                <option disabled selected></option>
                                <option value="Admin">Admin</option>
                                <option value="Moderator">Moderator</option>
                            </select>
                            <label for="role">Select Role</label>
                        </div>
                        <div class="form-floating mt-3 mb-3 position-relative">
                            <input type="password" class="form-control" id="password" placeholder="Enter password"
                                name="password" required>
                            <label for="password" class="text-dark">Password</label>
                            <button type="button"
                                class="btn btn-outline-secondary position-absolute top-50 end-0 translate-middle-y border-0"
                                id="togglePassword1"
                                style="border-top-left-radius: 0; border-bottom-left-radius: 0;height:58px">
                                <i class="fa fa-eye" id="toggleIcon1"></i>
                            </button>
                        </div>
                        <div class="form-floating mt-3 mb-3 position-relative">
                            <div class="form-floating mt-3 mb-3 position-relative">
                                <input type="password" class="form-control" id="repassword" placeholder="Re Enter password"
                                    name="repassword" required>
                                <label for="repassword" class="text-dark">Repeat Password</label>
                            </div>
                            <button type="button"
                                class="btn btn-outline-secondary position-absolute top-50 end-0 translate-middle-y border-0"
                                id="togglePassword2"
                                style="border-top-left-radius: 0; border-bottom-left-radius: 0;height:58px;">
                                <i class="fa fa-eye" id="toggleIcon2"></i>
                            </button>
                        </div>
                        <button type="submit" class="btn btn-primary">Add User</button>
                    </form>
                </div>
            </div>
        </div>

        <?php
        $status = isset($_GET['status']) ? htmlspecialchars($_GET['status']) : "";
        if ($status == "success") {
            echo '<div class="container alert alert-success alert-dismissible fade show mt-3" role="alert">
        <strong>Success!</strong> Profile created successfully.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
        }
        ?>
        <!-- Remove User Section -->
        <div class="container mt-5">
            <div class="card border-white border-3 bg-dark text-white" id="remove-user">
                <div class="card-body">
                    <h1 class="text-center">Remove Admin/ Moderator User</h1>
                    <form action="remove_user.php" method="POST">
                        <div class="mb-3">
                            <label for="remove_username" class="form-label">Username:</label>
                            <input type="text" class="form-control" id="remove_username" name="remove_username" required>
                        </div>
                        <button type="submit" class="btn btn-danger">Remove User</button>
                    </form>
                </div>
            </div>

            <?php
            $status = isset($_GET['status']) ? htmlspecialchars($_GET['status']) : "";
            if ($status == "userremovesuccess") {
                echo '<div class="container alert alert-success alert-dismissible fade show mt-3" role="alert">
            <strong>Success!</strong> User Removed successfully.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
            } else if ($status == "userremovefailed") {
                echo '<div class="container alert alert-danger alert-dismissible fade show mt-3" role="alert">
            <strong>ERROR!!</strong> User Removal failed.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
            } else if ($status == "userremoveusernotfound") {
                echo '<div class="container alert alert-danger alert-dismissible fade show mt-3" role="alert">
            <strong>ERROR!!</strong> User not found.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
            } else if ($status == "userremovemethodnotpost") {
                echo '<div class="container alert alert-danger alert-dismissible fade show mt-3" role="alert">
            <strong>ERROR!!</strong> Method Error.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
            }
            ?>

        </div>
    <?php endif; ?>
    <!-- User Table Section -->
    <div class="container mt-5">
        <div class="card border-white border-3 bg-dark text-white" id="admin-list">
            <div class="card-body">
                <h1 class="text-center">Admin List</h1>
                <div class="table-responsive-lg">
                <div class="mt-3">
                    <form method="GET">
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-lg-2 mb-2">
                                    <select name="filter" id="filter" class="form-select">
                                        <option value="userName">Username</option>
                                        <!-- <option value="name">Name</option> -->
                                    </select>
                                </div>
                                <div class="col-lg-9 mb-2">
                                    <input type="text" name="adminkeyword" id="adminkeyword" class="form-control">
                                </div>
                                <div class="col-lg-1 mb-2">
                                    <button type="submit" class="btn btn-primary text-center d-block">Filter</button>
                                </div>
                            </div>
                            <!-- <label for="filter" class="form-label">Filter by:</label> -->

                        </div>
                        <!-- <div class="mb-3">
                            <label for="keyword" class="form-label">Keyword:</label>

                        </div> -->

                    </form>
                </div>
                    <table class="table table-bordered table-hover table-dark table-lg bg-dark">
                        <thead>
                            <tr>
                                <th class="bg-secondary">Username</th>
                                <th class="bg-secondary">First Name</th>
                                <th class="bg-secondary">Last Name</th>
                                <th class="bg-secondary">Email</th>
                                <th class="bg-secondary">Role</th>
                            </tr>
                        </thead>
                        <!-- tablebody -->
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM users WHERE (role='Admin' OR role='Moderator')";
                            if(isset($_GET['filter']) && !empty($_GET['filter']) && isset($_GET['adminkeyword']) && !empty($_GET['adminkeyword'])){
                                $keyword = $_GET['adminkeyword'];
                                if($_GET['filter'] == 'userName'){
                                    $sql .= " AND userName LIKE '%$keyword%'";
                                }
                            }
                            $result = mysqli_query($connection, $sql);
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . $row['userName'] . "</td>";
                                    echo "<td>" . $row['fname'] . "</td>";
                                    echo "<td>" . $row['lname'] . "</td>";
                                    echo "<td>" . $row['email'] . "</td>";
                                    echo "<td>" . $row['role'] . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4'>No records found</td></tr>";
                            }
                            ?>
                    </table>
                </div>
            </div>
        </div>
    </div>



    <!-- Bootstrap Bundle with Popper -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <div id="footer">
        <?php include '../footer.php'; ?>
    </div>
    <?php if ($_SESSION['role'] != "Moderator"): ?>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
        <script>
            document.getElementById('togglePassword1').addEventListener('click', function () {
                const passwordField = document.getElementById('password');
                const toggleIcon = document.getElementById('toggleIcon1');
                const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', type);
                if (toggleIcon.classList.contains('fa-eye-slash')) {
                    toggleIcon.classList.add('fa-eye');
                } else {
                    toggleIcon.classList.add('fa-eye-slash');
                }
            });

            document.getElementById('togglePassword2').addEventListener('click', function () {
                const passwordField = document.getElementById('repassword');
                const toggleIcon = document.getElementById('toggleIcon2');
                const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', type);
                if (toggleIcon.classList.contains('fa-eye-slash')) {
                    toggleIcon.classList.add('fa-eye');
                } else {
                    toggleIcon.classList.add('fa-eye-slash');
                }
            });
        </script>
    <?php endif; ?>
</body>

</html>