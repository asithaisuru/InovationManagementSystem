<?php
session_start();
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    // header("Location: ../../../index.php");
    echo "<script>window.location.href='../../../index.php';</script>";
    exit();
}

require_once __DIR__ . '/../../../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../../');
$dotenv->load();

// Database connection
$connection = mysqli_connect($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $_ENV['DB_NAME']);
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

$query = "SELECT * FROM users WHERE userName = '$username'";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $fname = $row['fname'];
        $lname = $row['lname'];
        $email = $row['email'];
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- End of Bootstrap -->

    <title>Profile Editor</title>
</head>

<body class="bg-dark text-white">

    <?php include 'admin-nav.php'; ?>

    <div class="container">
        <div class="row">
            <div class="col-6">
                <div class="card bg-dark border-3 border-white">
                    <div class="card-header">
                        <h3 class="text-white">Update Profile Picture</h3>
                    </div>
                    <img class="card-img-top"
                        src="https://discoverymood.com/wp-content/uploads/2020/04/Mental-Strong-Women-min.jpg"
                        alt="Card image" style="width:100%">
                    <div class="card-body">
                        <form action="profile.php" method="POST" enctype="multipart/form-data">
                            <div class="form-group mt-3">
                                <input type="file" class="form-control" name="profile-pic" id="profile-pic">
                            </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
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
                </div>
            </div>
            <div class="mt-2 ms-auto" style="width: 200px;">
                <button type="submit" class="btn btn-primary">Update</button>
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

</html>
<?php
// Database connection


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userName = mysqli_real_escape_string($connection, $_POST['username']);
    $fname = mysqli_real_escape_string($connection, $_POST['fname']);
    $lname = mysqli_real_escape_string($connection, $_POST['lname']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);

    $selectedSkills = isset($_POST['skills']) ? $_POST['skills'] : [];

    $query = "UPDATE users SET userName = '$userName', fname = '$fname', lname = '$lname', email = '$email' WHERE userName = '$userName'";
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
            echo "Query2: $query2";
            mysqli_query($connection, $query2);
        } else {
            var_dump($selectedSkills);
            foreach ($selectedSkills as $skill) {
                $skill = mysqli_real_escape_string($connection, $skill);
                echo "Skill: $skill <br>";
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
?>