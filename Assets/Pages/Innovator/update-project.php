<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('location: ../../../index.php');
} else {
    $username = $_SESSION['username'];
}

include '../dbconnection.php';
$pid = $_POST['pid2nd'];
$sql = "SELECT noOfTasks FROM project WHERE userName = '$username' AND pid = '$pid'";
$result = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($result);
$dbnoOfTasks = $row['noOfTasks'];
// echo "dbnoOfTasks : " . $dbnoOfTasks;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pname = $_POST['pname'];
    $pdis = $_POST['pdis'];
    $projectCategory = $_POST['projectCategory'];
    $edate = $_POST['edate'];
    $numOfTasks = $_POST['taskCount'];
    // echo "numoftasks : ".$numOfTasks;

    $sql = "UPDATE project SET pname = '$pname', pdis = '$pdis', noOfTasks = '$numOfTasks', edate = '$edate', pcategory = '$projectCategory', userName = '$username' WHERE pid = '$pid'";
    $result = mysqli_query($connection, $sql);
    // echo "result :" . $result;
    if ($result) {
        //update the existing tasks and new task addition
        if ($dbnoOfTasks < $numOfTasks) {
            for ($i = 1; $i <= $dbnoOfTasks; $i++) {
                $taskID = 'p' . $pid . 'task' . $i;
                $taskName = $_POST['task' . $i];
                $taskDescription = $_POST['t' . $i . 'dis'];
                $sql = "UPDATE tasks SET taskName = '$taskName', discription = '$taskDescription' WHERE taskID = '$taskID'";
                $result = mysqli_query($connection, $sql);
                if (!$result) {
                    $em = "Project update failed.";
                    echo "<script>window.location.href='./edit-project.php?projectupdatestatus=error&msg=$em';</script>";
                    exit();
                    // echo "error in task creation. dbnoOfTasks < numOfTasks | Update";
                }
            }

            for ($i = $dbnoOfTasks + 1; $i <= $numOfTasks; $i++) {
                $taskID = 'p' . $pid . 'task' . $i;
                $taskName = $_POST['task' . $i];
                $taskDescription = $_POST['t' . $i . 'dis'];
                $sql = "INSERT INTO tasks (taskID, taskName, discription, pid) VALUES ('$taskID', '$taskName', '$taskDescription', '$pid')";
                $result = mysqli_query($connection, $sql);
                if (!$result) {
                    $em = "Project update failed.";
                    echo "<script>window.location.href='./edit-project.php?projectupdatestatus=error&msg=$em';</script>";
                    exit();
                    // echo "error in task creation. dbnoOfTasks < numOfTasks | Insert";
                }
            }

            $em = "Project update successfull.";
            echo "<script>window.location.href='./edit-project.php?projectupdatestatus=success&msg=$em';</script>";
            // echo "Successfull.";

        //update the existing tasks and past task deletion
        } else if ($dbnoOfTasks > $numOfTasks) {
            for ($i = 1; $i <= $numOfTasks; $i++) {
                $taskID = 'p' . $pid . 'task' . $i;
                $taskName = $_POST['task' . $i];
                $taskDescription = $_POST['t' . $i . 'dis'];
                $sql = "UPDATE tasks SET taskName = '$taskName', discription = '$taskDescription' WHERE taskID = '$taskID'";
                $result = mysqli_query($connection, $sql);
                if (!$result) {
                    $em = "Project update failed.";
                    echo "<script>window.location.href='./edit-project.php?projectupdatestatus=error&msg=$em';</script>";
                    exit();
                    // echo "error in task creation. dbnoOfTasks > numOfTasks | Update";
                }

            }

            for ($i = $numOfTasks + 1; $i <= $dbnoOfTasks; $i++) {
                $taskID = 'p' . $pid . 'task' . $i;
                $sql = "DELETE FROM tasks WHERE taskID = '$taskID'";
                $result = mysqli_query($connection, $sql);
                if (!$result) {
                    $em = "Project update failed.";
                    echo "<script>window.location.href='./edit-project.php?projectupdatestatus=error&msg=$em';</script>";
                    exit();
                    // echo "error in task creation. dbnoOfTasks > numOfTasks | Delete";
                }
            }

            $em = "Project update successfull.";
            echo "<script>window.location.href='./edit-project.php?projectupdatestatus=success&msg=$em';</script>";
            // echo "Successfull.";
        
        
        }else if ($dbnoOfTasks == $numOfTasks) {
            for ($i = 1; $i <= $numOfTasks; $i++) {
                $taskID = 'p' . $pid . 'task' . $i;
                $taskName = $_POST['task' . $i];
                $taskDescription = $_POST['t' . $i . 'dis'];
                $sql = "UPDATE tasks SET taskName = '$taskName', discription = '$taskDescription' WHERE taskID = '$taskID'";
                $result = mysqli_query($connection, $sql);
                if (!$result) {
                    $em = "Project update failed.";
                    echo "<script>window.location.href='./edit-project.php?projectupdatestatus=error&msg=$em';</script>";
                    exit();
                    // echo "error in task creation. dbnoOfTasks == numOfTasks | Update";
                }

            }
            $em = "Project update successfull.";
            echo "<script>window.location.href='./edit-project.php?projectupdatestatus=success&msg=$em';</script>";
            // echo "Successfull.";
        }
    } else {
        $em = "Project update failed.";
        echo "<script>window.location.href='./edit-project.php?projectupdatestatus=error&msg=$em';</script>";
        // echo "error in project update";
    }
}