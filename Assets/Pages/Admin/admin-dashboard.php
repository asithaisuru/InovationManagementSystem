<?php
session_start();
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    // header("Location: ../../../index.php");
    echo "<script>window.location.href='../../../index.php';</script>";
    exit();
}
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

    <div class="container mt-5" >
        <h1 class="text-center">Admin Dashboard</h1>
        <div class="card mt-4 border-white border-3 bg-dark text-white" id="add-user">
            <div class="card-body">
                <h1 class="text-white text-center">Add User</h1>
                <form action="add_user.php" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username:</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="firstname" class="form-label">First Name:</label>
                        <input type="text" class="form-control" id="firstname" name="firstname" required>
                    </div>
                    <div class="mb-3">
                        <label for="lastname" class="form-label">Last Name:</label>
                        <input type="text" class="form-control" id="lastname" name="lastname" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add User</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Remove User Section -->
    <div class="container mt-5">
        <div class="card border-white border-3 bg-dark text-white" id="remove-user">
            <div class="card-body">
                <h1 class="text-center">Remove User</h1>
                <form action="remove_user.php" method="POST">
                    <div class="mb-3">
                        <label for="remove_username" class="form-label">Username:</label>
                        <input type="text" class="form-control" id="remove_username" name="remove_username" required>
                    </div>
                    <button type="submit" class="btn btn-danger">Remove User</button>
                </form>
            </div>
        </div>
    </div>

    <!-- User Table Section -->
    <div class="container mt-5">
        <div class="card border-white border-3 bg-dark text-white" id="admin-list">
            <div class="card-body">
                <h1 class="text-center">Admin List</h1>
                <table class="table table-bordered bg-dark">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($users)): ?>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                                    <td><?php echo htmlspecialchars($user['firstname']); ?></td>
                                    <td><?php echo htmlspecialchars($user['lastname']); ?></td>
                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td><?php echo htmlspecialchars($user['role']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">No users found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>



    <!-- Bootstrap Bundle with Popper -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>



</body>

</html>


<?php include '../footer.php'; ?>