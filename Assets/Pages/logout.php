<?php
session_start();
if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
}

makeusernotactive($username);

function makeusernotactive($username)
{
    include './dbconnection.php';
    $sql = "UPDATE users SET active = 0 WHERE userName = '$username'";
    $result = mysqli_query($connection, $sql);
}

$_SESSION = array();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

session_destroy();


exit();
