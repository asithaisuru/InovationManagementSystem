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

    function getUsername()
    {
        return $this->username;
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

    function deleteSkill($connection, $skill_id)
    {
        $delete_sql = "DELETE FROM `user_skills` WHERE id = '" . $skill_id . "' ";
        if (mysqli_query($connection, $delete_sql)) {
            echo 'success';
        } else {
            echo 'error';
        }
    }

    function getProfileData($connection)
    {
        $query = "SELECT * FROM users WHERE userName = '$this->username'";
        $result = mysqli_query($connection, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
        }
        return $row;
    }

    function getProfilePicture($connection)
    {
        $profilePic = "https://img.freepik.com/free-vector/blue-circle-with-white-user_78370-4707.jpg?t=st=1716576375~exp=1716579975~hmac=be6ca419460bee7ca7e72244b5462a3ce71eff32f244d69b7646c4e984e6f4ee&w=740";
        $query = "SELECT profilePic FROM users WHERE userName = '$this->username'";
        $result = mysqli_query($connection, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if ($row['profilePic'] != null || $row['profilePic'] != "") {
                $profilePic = "../../img/profilePics/" . $row['profilePic'];
                $_SESSION['image_url'] = $row['profilePic'];
            }
        }

        return $profilePic;
    }

    function getUserSkills($connection)
    {

        $sql = "SELECT * FROM user_skills WHERE userName = '$this->username'";
        $result = mysqli_query($connection, $sql);


        return $result;
    }

    function resetPassword($connection, $newpassword, $confirmpassword)
    {
        $oldpassword = $this->password;
        if ($newpassword == $confirmpassword) {
            // Check if the new password and confirm password match
            $sql = "SELECT * FROM users WHERE userName = '$this->username'";
            $result = mysqli_query($connection, $sql);

            if ($result && mysqli_num_rows($result) > 0) {
                if ($row = mysqli_fetch_assoc($result)) {
                    $hash = $row['pass'];
                    if (verifyPassword($oldpassword, $hash)) {
                        // Verify old password
                        $hashnewpassword = hashPassword($newpassword);
                        $sql = "UPDATE users SET pass = '$hashnewpassword' WHERE userName = '$this->username'";
                        $result = mysqli_query($connection, $sql);

                        if ($result) {
                            // Password reset successful
                            echo '<div class="container alert alert-success alert-dismissible fade show mt-3" role="alert">
                            <strong>Success!</strong> Password Reset Successful.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                        } else {
                            // Password reset failed
                            echo '<div class="container alert alert-danger alert-dismissible fade show mt-3" role="alert">
                            <strong>ERROR!!</strong> Password Reset Failed.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                        }
                    } else {
                        // Old password is incorrect
                        echo '<div class="container alert alert-danger alert-dismissible fade show mt-3" role="alert">
                    <strong>ERROR!!</strong> Old Password is Incorrect.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                    }
                } else {
                    // User not found
                    echo '<div class="container alert alert-danger alert-dismissible fade show mt-3" role="alert">
                    <strong>ERROR!!</strong> User not found.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                }
            } else {
                // New password and confirm password do not match
                echo '<div class="container alert alert-danger alert-dismissible fade show mt-3" role="alert">
                    <strong>ERROR!!</strong> New Password and Confirm Password do not match.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            }
        }
    }

    function updateSkill($connection, $skill)
    {
        $sql = "INSERT INTO user_skills (userName,skill) VALUES ('$this->username','$skill')";
        //showing response messages
        if ($connection->query($sql) === TRUE) {
            $em = "Skill update successfully.";
            header("Location: ./profile.php?status=success&msg=$em");
        } else {
            $em = "Skill update failed.";
            header("Location: ./profile.php?status=error&msg=$em");
        }
    }
}
