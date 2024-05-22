<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Admin - Dashboard</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-dark">
        <a class="navbar-brand bg-dark text-white pl-3 pr-3" href="./admin-dashboard.php">Admin Dashboard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link text-white" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">Settings</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">                
                <li class="nav-item">
                    <a class="nav-link text-white bg-danger rounded-pill pr-3 pl-3" href="../../../index.php">Logout</a>
                </li>
                <li class="nav-item">
                    <img src="path/to/profile-pic.png" alt="Profile Pic" class="nav-link rounded-circle" style="width: 50px; height: 50px;">
                </li>
            </ul>
        </div>

