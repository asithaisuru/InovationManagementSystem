<?php
include '../dbconnection.php';
include '../password.php';
class Signup
{
    private $username;
    private $firstname;
    private $lastname;
    private $email;
    private $role;
    private $password;
    private $repassword;
    private $successStatusOfUserRegister;

    public function getSuccessStatusOfUserRegister(){
        return $this->successStatusOfUserRegister;
    }

    function __construct($username, $firstname, $lastname, $email, $role, $password, $repassword)
    {
        $this->username = $username;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->role = $role;
        $this->password = $password;
        $this->repassword = $repassword;
    }

    function validatepassword()
    {
        if ($this->password != $this->repassword) {
            echo '<script type="text/javascript">
                    window.onload = function () { alert("Passwords do not match. Please re-enter passwords."); }
                </script>';
            exit();
        }
    }

    function validateusername()
    {
        if (!preg_match("/^[a-zA-Z0-9]*$/", $this->username)) {
            echo '<script type="text/javascript">
                    window.onload = function () { alert("Invalid username format. Please enter a valid username."); }
                </script>';
            exit();
        }
    }

    function filteremail()
    {
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            echo '<script type="text/javascript">
                    window.onload = function () { alert("Invalid email format. Please enter a valid email address."); }
                </script>';
            exit();
        }
    }

    function checkemail($connection)
    {
        $query = "SELECT * FROM users WHERE email='$this->email'";
        $result = mysqli_query($connection, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            echo '<script type="text/javascript">
                        window.onload = function () { alert("Email already exists. Try a different email."); }
                    </script>';
            exit();
        }
    }

    function checkusername($connection)
    {
        $query = "SELECT * FROM users WHERE userName='$this->username'";
        $result = mysqli_query($connection, $query);
        if (mysqli_num_rows($result) > 0) {
            echo '<script type="text/javascript">
                    window.onload = function () { alert("Username already exists. Try a different username."); }
                </script>';
            exit();
        }
    }

    function insertuserintoDB($connection)
    {
        $hashpw = hashPassword($this->password);
        $sql = "INSERT INTO users (userName, fname, lname, email, role, pass) VALUES ('$this->username', '$this->firstname', '$this->lastname', '$this->email', '$this->role', '$hashpw')";
        if ($connection->query($sql) === false) {            
            echo "Error: " . $sql . "<br>" . $connection->error;
        }else{
            $this->successStatusOfUserRegister = true;
        }
    }

    function signup($connection)
    {
        $this->validateusername();
        $this->validatepassword();
        $this->filteremail();
        $this->checkemail($connection);
        $this->checkusername($connection);
        $this->insertuserintoDB($connection);
    }

}