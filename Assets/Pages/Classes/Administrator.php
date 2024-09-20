<?php
require_once "User.php";

class Administrator extends User
{
    function userPasswordReset($connection, $passwordresetusername, $password)
    {
        $passwordresetusername = $_POST['username'];
        $password = $_POST['password'];

        $sendingPassword = hashPassword($password);

        $sql = "UPDATE users SET pass = ? WHERE userName = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('ss', $sendingPassword, $passwordresetusername);

        if ($stmt->execute()) {
            echo "<script>window.location.href='./user-password-reset.php?userpasswordreset=success';</script>";
        } else {
            echo "<script>window.location.href='./user-password-reset.php?userpasswordreset=error';</script>";
        }
    }

    function sqlExecutor($connection, $sql)
    {
        $result1 = mysqli_query($connection, $sql);
        if (mysqli_num_rows($result1) > 0) {
            return $result1;
        } else {
            return null;
        }
    }

    function getAllTasks($connection)
    {
        $sql = "SELECT * FROM tasks";
        $result = mysqli_query($connection, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            return $result;
        } else {
            return null;
        }
    }

}