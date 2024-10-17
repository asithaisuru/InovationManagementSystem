<?php
require_once 'User.php';

class Innovator extends User
{
    function __construct($username, $password, $role = null, $firstname = null, $lastname = null, $email = null, $repassword = null)
    {
        parent::__construct($username, $password, $role, $firstname, $lastname, $email, $repassword);
    }

    function getProfilePicture($connection)
    {
        return parent::getProfilePicture($connection);
    }

    function getContributorsWithPID($connection, $pid)
    {
        $sql = "SELECT * FROM contributors WHERE pid = '$pid';";
        $result = mysqli_query($connection, $sql);

        if ($result) {
            return $result;
        } else {
            return "0";
        }
    }

    function getUserDetailsFromAUsername($connection, $username)
    {
        $sql1 = "SELECT * FROM users WHERE userName = '" . $username . "';";
        $result = mysqli_query($connection, $sql1);

        if ($result) {
            return $result;
        } else {
            return "0";
        }
    }

    function getIfAddedByAnAdmin($connection, $addedBy)
    {
        $sql = "SELECT role FROM users WHERE userName = '" . $addedBy . "';";
        $result = mysqli_query($connection, $sql);

        if ($result) {
            return $result;
        } else {
            return "0";
        }
    }

    function addAContributor($connection, $cname, $pid, $username)
    {
        $sql = "SELECT * FROM users WHERE BINARY userName = '$cname'";
        $result = mysqli_query($connection, $sql);
        if (mysqli_num_rows($result) > 0) {
            $sql = "INSERT INTO contributors (pid, userName,addedBy) VALUES ('$pid', '$cname','$username')";
            $result = mysqli_query($connection, $sql);
            if ($result) {
                echo "<script>window.location.href='./add-contributor.php?pid=" . $pid . "&addcontributor=success';</script>";
            } else {
                echo "<script>window.location.href='./add-contributor.php?pid=" . $pid . "&addcontributor=error';</script>";
            }
        } else {
            echo "<script>window.location.href='./add-contributor.php?pid=" . $pid . "&addcontributor=error';</script>";
        }
    }

    function getAllProjectsForAUsername($connection, $username)
    {
        $sql = "SELECT * FROM project WHERE userName = '" . $username . "';";
        $result = mysqli_query($connection, $sql);

        if ($result) {
            return $result;
        } else {
            return "0";
        }
    }

    function projectDeleteConfermation($pid)
    {
        echo "<script>
        if (confirm('Are you sure you want to delete this project?')) {
            window.location.href = 'delete-project.php?confirm=true&pid=' + $pid;
        } else {
            window.location.href = 'delete-project.php?pid=' + $pid;
        }
    </script>";
        exit();
    }

    function deleteAProject($connection, $pid)
    {
        $sql = "DELETE FROM tasks WHERE pid = '$pid';"; // Removing from tasks
        if (mysqli_query($connection, $sql)) {
            $sql = "DELETE FROM contributors WHERE pid = '$pid';"; // Removing from contributors
            if (mysqli_query($connection, $sql)) {
                $sql = "DELETE FROM project WHERE pid = '$pid';"; // Removing from project
                if (mysqli_query($connection, $sql)) {
                    echo "<script>window.location.href='delete-project.php?projectdeletestatus=success';</script>";
                    exit();
                } else {
                    echo "<script>window.location.href='delete-project.php?projectdeletestatus=error';</script>";
                    exit();
                }
            } else {
                echo "<script>window.location.href='delete-project.php?projectdeletestatus=error';</script>";
                exit();
            }
        } else {
            echo "<script>window.location.href='delete-project.php?projectdeletestatus=error';</script>";
            exit();
        }
    }

    function getProjectDetails($connection, $pid)
    {
        $sql = "SELECT * FROM project WHERE pid = '$pid'";
        $result = mysqli_query($connection, $sql);

        if ($result) {
            return $result;
        } else {
            return "0";
        }
    }

    function getNoOfTasksForAProject($connection, $pid)
    {
        $sql = "SELECT COUNT(*) FROM tasks WHERE pid = '$pid'";
        $result = mysqli_query($connection, $sql);
        $row = mysqli_fetch_array($result);
        return $row[0];
    }

    function updateProject($connection, $pname, $pdis, $numOfTasks, $edate, $projectCategory, $username, $pid, $dbnoOfTasks)
    {
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
                    $status = 'Not Assigned';
                    $sql = "INSERT INTO tasks (taskID, taskName, discription, pid, status) VALUES ('$taskID', '$taskName', '$taskDescription', '$pid', '$status')";
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


            } else if ($dbnoOfTasks == $numOfTasks) {
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

    function getContributorsWithUsername($connection, $username)
    {
        $sql = "SELECT * FROM contributors WHERE userName = '$username';";
        $result = mysqli_query($connection, $sql);

        if ($result) {
            return $result;
        } else {
            return "0";
        }
    }

    function createAProject($connection, $pname, $pdis, $numOfTasks, $sdate, $edate, $projectCategory, $username)
    {
        $sql = "INSERT INTO project (pname, pdis, noOfTasks, sdate, edate, pcategory, userName) VALUES ('$pname', '$pdis', '$numOfTasks', '$sdate', '$edate', '$projectCategory', '$username')";
        $result = mysqli_query($connection, $sql);
        echo "result :" . $result;
        if ($result) {
            $projectID = mysqli_insert_id($connection);
            for ($i = 1; $i <= $numOfTasks; $i++) {
                $taskID = 'p' . $projectID . 'task' . $i;
                $taskName = $_POST['task' . $i];
                $taskDescription = $_POST['t' . $i . 'dis'];
                $sql = "INSERT INTO tasks (taskID, taskName, discription, pid, status) VALUES ('$taskID', '$taskName', '$taskDescription', '$projectID', 'Not Assigned')";
                $result = mysqli_query($connection, $sql);
            }
            // $em = "Project creation successfull.";
            // echo "<script>window.location.href='./project-creation.php?projectcreationstatus=success&msg=$em';</script>";
            $sql = "SELECT * FROM project WHERE pname='$pname' AND pdis='$pdis' AND noOfTasks='$numOfTasks' AND sdate='$sdate' AND edate='$edate' AND pcategory='$projectCategory' AND userName='$username'";
            $result = mysqli_query($connection, $sql);
            $row = mysqli_fetch_assoc($result);
            $pid = $row['pid'];
            echo "<script>window.location.href='./project-details.php?pid=" . $pid . "';</script>";
        } else {
            $em = "Project creation failed.";
            echo "<script>window.location.href='./project-creation.php?projectcreationstatus=error&msg=$em';</script>";
            // echo "<script>alert('Failed to create project. error: ')</script>";
        }
    }

    function getTasksFromAPID($connection, $pid)
    {
        $sql = "SELECT * FROM tasks WHERE pid = '$pid'";
        $result = mysqli_query($connection, $sql);
        if ($result) {
            return $result;
        } else {
            return "0";
        }
    }

    function updateTaskAssignedTo($connection, $taskID, $assignedTo, $pid, $username, $time)
    {
        $updateQuery = "UPDATE tasks SET assignedTo = '$assignedTo', status = 'Assigned', assignedby = '$username', assignedon='$time' WHERE taskID = '$taskID' AND pid = '$pid'";
        if (!$connection->query($updateQuery)) {
            echo "<script>window.location.href='./project-details.php?projectupdatestatus=error';</script>";
        } else {
            echo "<script>window.location.href='./project-details.php?projectupdatestatus=success';</script>";
        }
    }

    function updateTaskStatus($connection, $pid, $taskID, $status, $time)
    {
        $updateStatusQuery = "UPDATE tasks SET status = '$status', updatedon='$time' WHERE taskID = '$taskID' AND pid = '$pid'";
        if (!$connection->query($updateStatusQuery)) {
            echo "<script>window.location.href='./project-details.php?taskstatusupdate=error';</script>";
        } else {
            echo "<script>window.location.href='./project-details.php?taskstatusupdate=success';</script>";
        }
    }

    function removeContributor($connection, $pid, $assignedTo, $role)
    {
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
                echo "<script>window.location.href='./add-contributor.php?pid=" . $pid . "&removecontributor=error';</script>";
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
                        echo "<script>window.location.href='./add-contributor.php?pid=" . $pid . "&removecontributor=success';</script>";
                        // echo "Success";
                        exit();
                    } else {
                        echo "<script>window.location.href='./add-contributor.php?pid=" . $pid . "&removecontributor=error';</script>";
                        // echo "error";
                        exit();
                    }
                } else {
                    if ($stmt->affected_rows > 0) {
                        echo "<script>window.location.href='./add-contributor.php?pid=" . $pid . "&removecontributor=success';</script>";
                        // echo "Success";
                        exit();
                    } else {
                        echo "<script>window.location.href='./add-contributor.php?pid=" . $pid . "&removecontributor=error';</script>";
                        // echo "error";
                        exit();
                    }
                }
            }
        }
    }

    function submitRating($connection, $userName, $rating, $ratingBy, $comment)
    {
        $query = "INSERT INTO user_ratings (userName, rating, ratingBy, comment) VALUES ('$userName', '$rating', '$ratingBy', '$comment')";
        $result = mysqli_query($connection, $query);
        if ($result) {
            header("Location: ./view-profile.php?userName=$userName&ratingstatus=success");
            exit();
        } else {
            // echo "$connection->error";
            header("Location: ./view-profile.php?userName=$userName&ratingstatus=error");
            exit();
        }
    }

    function viewProfileGetProfilePic($connection, $viewUserName)
    {
        $viewerprofilePic = "";
        $query = "SELECT profilePic FROM users WHERE userName = '$viewUserName'";
        $result = mysqli_query($connection, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $viewerprofilePic = "../../img/profilePics/" . $row['profilePic'];
            $_SESSION['image_url'] = $row['profilePic'];
        } else {
            $viewerprofilePic = "https://img.freepik.com/free-vector/blue-circle-with-white-user_78370-4707.jpg?t=st=1716576375~exp=1716579975~hmac=be6ca419460bee7ca7e72244b5462a3ce71eff32f244d69b7646c4e984e6f4ee&w=740";
        }

        return $viewerprofilePic;
    }

    function viewProfileGetUserSkills($connection, $viewUserName)
    {
        $sql = "SELECT * FROM user_skills WHERE userName = '$viewUserName'";
        $result = mysqli_query($connection, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            return $result;
        } else {
            return "0";
        }
    }

    function viewProfileGetUserRatings($connection, $viewUserName)
    {
        $query = "SELECT * FROM user_ratings WHERE userName = '$viewUserName'";
        $result = mysqli_query($connection, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            return $result;
        } else {
            return "0";
        }
    }

    function getProducts($connection, $viewUserName, $viewUsernameEqualsUsername)
    {
        if ($viewUsernameEqualsUsername) {
            $sql = "SELECT * FROM items WHERE userName = '$viewUserName';";
        } else {
            $sql = "SELECT * FROM items WHERE userName = '$viewUserName' AND status = 'Approved';";
        }

        $result = mysqli_query($connection, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            return $result;
        } else {
            return "0";
        }
    }
}
