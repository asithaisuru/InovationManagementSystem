<?php
session_start();
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    // header("Location: ../../../index.php");
    echo "<script>window.location.href='../../../index.php';</script>";
    exit();
}

include '../dbconnection.php';

$query = "SELECT * FROM users WHERE userName = '$username'";
$result = mysqli_query($connection, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $fname = $row['fname'];
    $lname = $row['lname'];
    $email = $row['email'];
}

$query = "SELECT * FROM profilePic WHERE userName = '$username'";
$result = mysqli_query($connection, $query);
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $profilePic = "../../img/profilePics/" . $row['image_url'];
    $_SESSION['image_url'] = $row['image_url'];
    // echo $_SESSION['image_url'];
} else {
    $profilePic = "https://img.freepik.com/free-vector/blue-circle-with-white-user_78370-4707.jpg?t=st=1716576375~exp=1716579975~hmac=be6ca419460bee7ca7e72244b5462a3ce71eff32f244d69b7646c4e984e6f4ee&w=740";

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Profile Editor</title>
</head>

<body class="bg-dark text-white">

    <?php
    if ($_SESSION['role'] == "Admin" || $_SESSION['role'] == "Moderator") {
        include './admin-nav.php';
    } else if ($_SESSION['role'] == "Innovator") {
        include '../Innovator/innovator-nav.php';
    }
    ?>

    <div class="container">
        <div class="row">
            <div class="col-lg-6 mb-2">
                <div class="card bg-dark border-3 border-white">
                    <div class="card-header">
                        <h3 class="text-white">Update Profile Picture</h3>
                    </div>
                    <img class="card-img-top" src=<?php echo $profilePic ?> alt="Card image" style="width:100%">
                    <div class="card-body">
                        <form action="../upload.php?un=<?php echo $username ?>" method="POST"
                            enctype="multipart/form-data">
                            <div class="form-group mt-3">
                                <input type="file" class="form-control" name="profile-pic" id="profile-pic">
                            </div>
                            <div class="mt-4 mb-4 ms-auto" style="width: 200px;">
                                <button type="submit" class="btn btn-primary" value="Upload" name="submit">Update
                                    Image</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <form action="profile.php" method="POST">
                    <div class="card bg-dark border-3 border-white">
                        <div class="card-header">
                            <h3 class="text-white">Update Personal Information</h3>
                        </div>
                        <div class="card-body">

                            <fieldset>
                                <legend class="text-white">Persenal info:</legend>
                                <div class="form-floating mb-3 mt-3">
                                    <input type="text" class="form-control" id="username" placeholder="Enter Username"
                                        name="username" value="<?php echo $username ?>">
                                    <label for="username">Username</label>
                                </div>
                                <div class="form-floating mb-3 mt-3">
                                    <input type="text" class="form-control" id="fname" placeholder="Enter First Name"
                                        name="fname" value="<?php echo $fname ?>">
                                    <label for="fname">First Name</label>
                                </div>
                                <div class="form-floating mb-3 mt-3">
                                    <input type="text" class="form-control" id="lname" placeholder="Enter Last Name"
                                        name="lname" value="<?php echo $lname ?>">
                                    <label for="lname">Last Name</label>
                                </div>
                                <div class="form-floating mb-3 mt-3">
                                    <input type="text" class="form-control" id="email" placeholder="Enter Email"
                                        name="email" value="<?php echo $email ?>">
                                    <label for="lname">Email</label>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend class="text-white">Skills:</legend>
                                <div id="selected-skills" class="list-group-item list-group-item-action"></div>
                                <div class="mb-3">
                                    <div id="selected-skills" class="mb-3">
                                        <div class="form-floating mb-3 mt-3">
                                            <input type="text" class="form-control" id="skill-input" name="skill-input"
                                                placeholder="Enter Skill">
                                            <label for="skill-input">Skilled languages</label>
                                        </div>
                                        <div id="suggestions" class="list-group mt-1"></div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="mb-3 ms-auto" style="width: 200px;">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
            </div>

            </form>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const skills = ["HTML", "CSS", "JavaScript", "PHP", "Python", "Java", "C++", "C#", "Ruby", "Go"];
                const skillInput = document.getElementById('skill-input');
                const suggestionsContainer = document.getElementById('suggestions');
                const selectedSkillsContainer = document.getElementById('selected-skills');
                const selectedSkills = [];

                skillInput.addEventListener('input', function () {
                    const query = skillInput.value.toLowerCase();
                    suggestionsContainer.innerHTML = '';

                    if (query) {
                        const filteredSkills = skills.filter(skill => skill.toLowerCase().includes(query));
                        filteredSkills.forEach(skill => {
                            const suggestionItem = document.createElement('a');
                            suggestionItem.className = 'list-group-item list-group-item-action';
                            suggestionItem.innerText = skill;
                            suggestionItem.addEventListener('click', function () {
                                if (!selectedSkills.includes(skill)) {
                                    selectedSkills.push(skill);
                                    updateSelectedSkills();
                                }
                                skillInput.value = '';
                                suggestionsContainer.innerHTML = '';
                            });
                            suggestionsContainer.appendChild(suggestionItem);
                        });
                    }
                });

                skillInput.addEventListener('keydown', function (event) {
                    if (event.key === 'Enter' && skillInput.value.trim() !== '') {
                        event.preventDefault();
                        const skill = skillInput.value.trim();
                        if (!selectedSkills.includes(skill)) {
                            selectedSkills.push(skill);
                            updateSelectedSkills();
                        }
                        skillInput.value = '';
                        suggestionsContainer.innerHTML = '';
                    }
                });

                function updateSelectedSkills() {
                    selectedSkillsContainer.innerHTML = '';
                    selectedSkills.forEach(skill => {
                        const badge = document.createElement('span');
                        badge.className = 'badge bg-primary me-2 mb-2';
                        badge.innerText = skill;

                        const removeButton = document.createElement('button');
                        removeButton.className = 'btn-close ms-2';
                        removeButton.setAttribute('aria-label', 'Close');
                        removeButton.addEventListener('click', function () {
                            const index = selectedSkills.indexOf(skill);
                            if (index > -1) {
                                selectedSkills.splice(index, 1);
                                updateSelectedSkills();
                            }
                        });

                        badge.appendChild(removeButton);
                        selectedSkillsContainer.appendChild(badge);
                    });
                }
            });
        </script>
</body>

<?php
$status = isset($_GET['status']) ? htmlspecialchars($_GET['status']) : "";
$msg = isset($_GET['msg']) ? htmlspecialchars($_GET['msg']) : "";
if ($status == "success") {
    echo '<div class="container alert alert-success alert-dismissible fade show mt-3" role="alert">
    <strong>Success!</strong> ' . $msg . '
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
} else if ($status == "error") {
    echo '<div class="container alert alert-danger alert-dismissible fade show mt-3" role="alert">
    <strong>ERROR!!</strong> ' . $msg . '
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
}
?>

</html>
<?php
// Database connection


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newuserName = mysqli_real_escape_string($connection, $_POST['username']);
    $newfname = mysqli_real_escape_string($connection, $_POST['fname']);
    $newlname = mysqli_real_escape_string($connection, $_POST['lname']);
    $newemail = mysqli_real_escape_string($connection, $_POST['email']);

    $selectedSkills = isset($_POST['skills']) ? $_POST['skills'] : [];

    if ($newuserName == $username && $newfname == $fname && $newlname == $lname && $newemail == $email) {
        echo '<div class="alert alert-warning alert-dismissible fade show mt-2" role="alert">
        <strong>Warning!</strong> Nothing Changed. Please Change the fields to update.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    } else {
        $query = "UPDATE users SET userName = '$newuserName', fname = '$newfname', lname = '$newlname', email = 'new$email' WHERE userName = '$userName'";
        mysqli_query($connection, $query);
        // echo "Query: $query";
        if (mysqli_query($connection, $query)) {
            // echo "connection successful25567";
            $query1 = "SELECT * FROM user_skills WHERE userName = '$userName';";
            $result = mysqli_query($connection, $query1);
            // echo "Query1: $query1";
            // echo mysqli_num_rows($result);

            if ($result && mysqli_num_rows($result) > 0) {
                $query2 = "DELETE FROM user_skills WHERE userName = '$userName'";
                // echo "Query2: $query2";
                mysqli_query($connection, $query2);
            } else {
                // var_dump($selectedSkills);
                foreach ($selectedSkills as $skill) {
                    $skill = mysqli_real_escape_string($connection, $skill);
                    // echo "Skill: $skill <br>";
                    $query = "INSERT INTO user_skills (userName, skill) VALUES ('$userName', '$selectedSkills')";
                    if (mysqli_query($connection, $query)) {
                        echo "Inserted skill: $skill <br>";
                    } else {
                        echo "Error inserting skill: $skill - " . mysqli_error($connection) . "<br>";
                    }
                }
                echo '<div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
        <strong>Success!</strong> Profile updated successfully.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
            }
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($connection);
            echo '<div class="alert alert-danger mt-2" alert-dismissible fade show mt-2" role="alert">
                <strong>ERROR!!</strong> ' . $query . '<br>' . mysqli_error($connection) . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
        }
    }
}
?>

<?php include '../footer.php'; ?>