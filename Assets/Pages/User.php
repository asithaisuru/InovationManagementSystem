<?php
class User
{
    private $username;
    private $firstname;
    private $lastname;
    private $email;
    private $role;
    private $password;
    private $repassword;

    function __construct($username, $password, $role = null, $firstname = null, $lastname = null, $email = null, $repassword = null)
    {
        $this->username = $username;
        $this->password = $password;
        $this->role = $role;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->repassword = $repassword;
    }

    // Signup process
    function register($connection)
    {
        // Validate username, password, and email
        if (!preg_match("/^[a-zA-Z0-9]*$/", $this->username)) {
            echo '<script>alert("Invalid username format.");</script>';
            return;
        }

        if ($this->password !== $this->repassword) {
            echo '<script>alert("Passwords do not match.");</script>';
            return;
        }

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            echo '<script>alert("Invalid email format.");</script>';
            return;
        }

        // Check if email or username already exists
        $query = "SELECT * FROM users WHERE email = ? OR userName = ?";
        $statement = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($statement, "ss", $this->email, $this->username);
        mysqli_stmt_execute($statement);
        $result = mysqli_stmt_get_result($statement);

        if (mysqli_num_rows($result) > 0) {
            echo '<script>alert("Email or username already exists.");</script>';
            return;
        }

        // Insert new user into database
        $hashpw = password_hash($this->password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (userName, fname, lname, email, role, pass) VALUES (?, ?, ?, ?, ?, ?)";
        $statement = mysqli_prepare($connection, $sql);
        mysqli_stmt_bind_param($statement, "ssssss", $this->username, $this->firstname, $this->lastname, $this->email, $this->role, $hashpw);

        if (!mysqli_stmt_execute($statement)) {
            echo "Error: " . $connection->error;
        } else {
            $_SESSION['username'] = $this->username;
            $_SESSION['role'] = $this->role;
            echo "<script>window.location.href='./Admin/profile.php';</script>";
        }
    }

    // Login process
    function login($connection)
    {
        $query = "SELECT pass, role FROM users WHERE userName = ?";
        $statement = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($statement, "s", $this->username);
        mysqli_stmt_execute($statement);
        $result = mysqli_stmt_get_result($statement);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $hash = $row['pass'];
            if (password_verify($this->password, $hash)) {
                $_SESSION['username'] = $this->username;
                $_SESSION['role'] = $row['role'];
                $this->role = $row['role'];
                switch ($this->role) {
                    case 'Innovator':
                        echo "<script>window.location.href='Assets/Pages/Innovator/innovator-dashboard.php';</script>";
                        break;
                    case 'Supplier':
                        echo "<script>window.location.href='Assets/Pages/Supplier/supplier-dashboard.php';</script>";
                        break;
                    case 'Admin':
                        echo "<script>window.location.href='Assets/Pages/Admin/admin-dashboard.php';</script>";
                        break;
                    case 'Buyer':
                        echo "<script>window.location.href='Assets/Pages/Buyer/buyer-dashboard.php';</script>";
                        break;

                }
            } else {
                echo '<script>alert("Invalid username or password.");</script>';
            }
        } else {
            echo '<script>alert("User not found.");</script>';
        }
    }

    public function editProfile($connection, $newfname, $newlname, $newemail)
    {
        // Sanitize inputs
        $newfname = mysqli_real_escape_string($connection, $newfname);
        $newlname = mysqli_real_escape_string($connection, $newlname);
        $newemail = mysqli_real_escape_string($connection, $newemail);

        // Check if nothing has changed
        if ($newfname == $this->firstname && $newlname == $this->lastname && $newemail == $this->email) {
            echo '<div class="alert alert-warning alert-dismissible fade show mt-2" role="alert">
                    <strong>Warning!</strong> Nothing Changed. Please change the fields to update.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
            return;
        }

        // Update query
        $query = "UPDATE users SET fname = ?, lname = ?, email = ? WHERE userName = ?";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "ssss", $newfname, $newlname, $newemail, $this->username);

        // Execute the update
        if (mysqli_stmt_execute($stmt)) {
            $this->firstname = $newfname;
            $this->lastname = $newlname;
            $this->email = $newemail;

            $ms = "Personal information updated successfully.";
            echo '<script>
                    window.location.href = "profile.php?status=success&msg=' . $ms . '";
                </script>';
        } else {
            $ms = "Error updating profile: " . mysqli_error($connection);
            echo '<script>
                    window.location.href = "profile.php?status=error&msg=' . $ms . '";
                </script>';
        }
    }
}
