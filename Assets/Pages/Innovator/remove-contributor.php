<?php

session_start();
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $role = $_SESSION['role'];
    if ($role != 'Innovator' && $role != "Admin") {
        echo "<script>window.location.href='../../../sign-in.php';</script>";
        exit();
    }
} else {
    // header("Location: ../../../index.php");
    echo "<script>window.location.href='../../../sign-in.php';</script>";
    exit();
}

$pid = isset($_GET['pid']) ? htmlspecialchars($_GET['pid']) : "";
$assignedTo = isset($_GET['userName']) ? htmlspecialchars($_GET['userName']) : "";

include '../dbconnection.php';

$sql = "SELECT addedBy FROM contributors WHERE pid = '$pid' AND userName = '$assignedTo'";
$result = mysqli_query($connection, $sql);
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $addedBy = $row['addedBy'];
    $sql = "SELECT role FROM users WHERE username = '$addedBy'";
    $result = mysqli_query($connection, $sql);
    $row = mysqli_fetch_assoc($result);
    $addedByrole = $row['role'];
    // echo $addedByrole;
    // echo $role;
    // exit();
    if (($addedByrole == 'Admin') && ($role != 'Admin')) {
        echo "<script>window.location.href='./add-contributor.php?removecontributor=error';</script>";
        exit();
    } else {
        $sql = "DELETE FROM contributors WHERE pid = ? AND userName = ?"; // Modified column name to 'username'
        $stmt = $connection->prepare($sql);
        if ($stmt === false) {
            die('Error: ' . $connection->error);
        }
        $stmt->bind_param("is", $pid, $assignedTo);
        $stmt->execute();

        $query = "SELECT * FROM tasks WHERE pid = ? AND assignedTo = ?";
        $stmt1 = $connection->prepare($query);
        if ($stmt1 === false) {
            die('Error: ' . $connection->error);
        }
        $stmt1->bind_param("is", $pid, $assignedTo);
        $stmt1->execute();
        $result = $stmt1->get_result();

        if ($result->num_rows > 0) {
            $sql2 = "UPDATE tasks SET assignedTo = '', status = 'Not Assigned' WHERE pid = ? AND assignedTo = ?";
            $stmt2 = $connection->prepare($sql2);
            if ($stmt2 === false) {
                die('Error: ' . $connection->error);
            }
            $stmt2->bind_param("is", $pid, $assignedTo);
            $stmt2->execute();

            if ($stmt->affected_rows > 0 && $stmt2->affected_rows > 0) {
                echo "<script>window.location.href='./add-contributor.php?removecontributor=success';</script>";
                // echo "Success";
                exit();
            } else {
                echo "<script>window.location.href='./add-contributor.php?removecontributor=error';</script>";
                // echo "error";
                exit();
            }

        } else {
            if ($stmt->affected_rows > 0) {
                echo "<script>window.location.href='./add-contributor.php?removecontributor=success';</script>";
                // echo "Success";
                exit();
            } else {
                echo "<script>window.location.href='./add-contributor.php?removecontributor=error';</script>";
                // echo "error";
                exit();
            }
        }
    }
}