<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'Supplier') {
    header("Location: ../../../sign-in.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $prodName = $_POST['prodName'];
    $prodDis = $_POST['prodDis'];
    $prodPrice = $_POST['prodPrice'];
    $userName = $_SESSION['username'];

    // Handle file upload
    $target_dir = "../../img/prodImgs/";
    $imageFileType = strtolower(pathinfo($_FILES["prodImage"]["name"], PATHINFO_EXTENSION));
    $uniqueName = uniqid() . '.' . $imageFileType; // Generate a unique file name
    $target_file = $target_dir . $uniqueName;
    $uploadOk = 1;

    // Check if image file is an actual image or fake image
    $check = getimagesize($_FILES["prodImage"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["prodImage"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["prodImage"]["tmp_name"], $target_file)) {
            // Insert into database
            include('../dbconnection.php'); // Include your database connection file

            $status = "Pending";

            $stmt = $connection->prepare("INSERT INTO items (prodName, prodDis, prodImg, prodPrice, userName, status) VALUES (?, ?, ?, ?, ?,?)");
            $stmt->bind_param("sssdss", $prodName, $prodDis, $target_file, $prodPrice, $userName, $status);

            if ($stmt->execute()) {
                echo "<script>alert('New item added successfully!'); window.location.href = './addproduct.php';</script>";
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close(); // Close the statement
            $connection->close(); // Close the database connection
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
