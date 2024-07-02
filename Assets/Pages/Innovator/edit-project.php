<?php
session_start();
if (isset($_SESSION['username']) || isset($_SESSION['role'])) {
    $username = $_SESSION['username'];
    $role = $_SESSION['role'];
    if ($role != 'Innovator') {
        if ($role == 'Admin') {
            echo "<script>window.location.href='../error.php?msj=Access Denied';</script>";
            exit();
        }
        echo "<script>window.location.href='../../../index.php';</script>";
        exit();
    }
} else {
    echo "<script>window.location.href='../../../index.php';</script>";
    exit();
}
$pidfrompdetails = isset($_GET['pid']) ? htmlspecialchars($_GET['pid']) : "";
include '../dbconnection.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IMS - Edit Projects</title>
    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
        (function () {
            var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/664344a19a809f19fb30bb2f/1htrc868i';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
    <!--End of Tawk.to Script-->
</head>

<body class="bg-dark text-white">
    <?php include '../Innovator/innovator-nav.php'; ?>

    <div class="container mt-5 bg-dark">
        <h2 class="text-center">Edit Project</h2>

        <?php
        $status = isset($_GET['projectupdatestatus']) ? htmlspecialchars($_GET['projectupdatestatus']) : "";
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
        <div class="card bg-dark border-3 border-white mt-4">
            <div class="card-body">
                <form action="edit-project.php" method="post" id="getProject">
                    <div class="form-floating mb-3 mt-3">
                        <select class="form-select mt-3" required name="pid" id="pid">
                            <?php
                            $sql = "SELECT * FROM project WHERE userName = '$username';";
                            $result = mysqli_query($connection, $sql);
                            echo "<option disabled selected></option>";
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value=" . $row['pid'] . ">" . $row['pid'] . " - " . $row['pname'] . "</option>";
                                    if ($row['pid'] == $pidfrompdetails) {
                                        echo '<script>
                                            document.getElementById("pid").value = ' . $pidfrompdetails . ';
                                            document.getElementById("getProject").submit();
                                        </script>';
                                    }
                                }
                            } else {
                                echo "<option disabled>--Projects not found--</option>";
                            }
                            ?>
                        </select>
                        <label for="pid">Select Project</label>
                    </div>
                    <button type="submit" class="btn btn-success">Get Project</button>
                </form>
            </div>
        </div>
        <div id="projectDetailsContainer" class="card bg-dark border-3 border-white mt-4" style="display:none;">
            <form action="./update-project.php" method="post">
                <div class="card-body">
                    <div class="form-floating mb-3 mt-3">
                        <input type="text" class="form-control" id="pname" placeholder="Enter Project Name" name="pname"
                            required>
                        <label for="pname" class="text-dark">Project Name</label>
                    </div>
                    <div class="form-floating mb-3 mt-3">
                        <textarea class="form-control" id="pdis" name="pdis" rows="10" required></textarea>
                        <label for="pdis" class="text-dark">Project Description</label>
                    </div>
                    <div id="task-container" class="border-3 border-white">
                        <div id="taskDiv1" class="form-floating mb-3 mt-3">
                            <input type="text" class="form-control" id="task1" placeholder="Enter Task 1" name="task1"
                                required>
                            <label for="task1" class="text-dark">Task 1</label>
                        </div>
                        <div class="form-floating mb-3 mt-3">
                            <textarea class="form-control" id="t1dis" name="t1dis" rows="10" required></textarea>
                            <label for="t1dis" class="text-dark">Task 1 Description</label>
                            <hr class="border-white border-3">
                        </div>
                    </div>
                    <button class="btn btn-primary" onclick="addTask()">Add Task</button>
                    <button class="btn btn-danger" onclick="deleteTask()" id="delete-task" type="button">Delete
                        Task</button>
                    <div class="form-floating mb-3 mt-3">
                        <select class="form-select mt-3" required name="projectCategory" id="projectCategory">
                            <option disabled selected></option>
                            <option value="Web Development">Web Development</option>
                            <option value="Mobile Development">Mobile Development</option>
                            <option value="Desktop Development">Desktop Development</option>
                            <option value="Machine Learning">Machine Learning</option>
                            <option value="Data Science">Data Science</option>
                            <option value="Artificial Intelligence">Artificial Intelligence</option>
                            <option value="Cyber Security">Cyber Security</option>
                            <option value="Networking">Networking</option>
                            <option value="Game Development">Game Development</option>
                            <option value="Other">Other</option>
                        </select>
                        <label for="projectCategory">Project Category</label>
                    </div>
                    <div class="row">
                        <div class="col-md-6 text-center">
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control" id="sdate" name="sdate" required disabled
                                    value="<?php echo date('Y-m-d') ?>">
                                <label for="sdate">Start Date</label>
                            </div>
                        </div>
                        <div class="col-md-6 text-center">
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control" id="edate" name="edate" required>
                                <label for="edate">End Date</label>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="pid2nd" id="pid2nd" value="">
                    <input type="hidden" name="taskCount" id="taskCount" value="1">
                    <button type="submit" class="btn btn-success mt-3">Update Project</button>
                </div>
            </form>
        </div>

</body>

<script>
    let taskCount = 1;
    disableDeleteButton();

    function disableDeleteButton() {
        if (taskCount == 1) {
            document.getElementById('delete-task').disabled = true;
        } else if (taskCount > 1) {
            document.getElementById('delete-task').disabled = false;
        }
    }

    function addTask() {
        taskCount++;
        const taskContainer = document.getElementById('task-container');
        const newTask = document.createElement('div');
        newTask.setAttribute('id', 'taskDiv' + taskCount);
        newTask.classList.add('form-floating', 'mb-3', 'mt-3');
        newTask.innerHTML = `
            <input type="text" class="form-control" id="task${taskCount}" placeholder="Enter Task ${taskCount}" name="task${taskCount}" required>
            <label for="task${taskCount}" class="text-dark">Task ${taskCount}</label>
        `;
        const newTaskDescription = document.createElement('div');
        newTaskDescription.classList.add('form-floating', 'mb-3', 'mt-3');
        newTaskDescription.innerHTML = `
            <textarea class="form-control" id="t${taskCount}dis" name="t${taskCount}dis" rows="10" required></textarea>
            <label for="t${taskCount}dis" class="text-dark">Task ${taskCount} Description</label>
            <hr class="border-white border-3">
        `;
        taskContainer.appendChild(newTask);
        taskContainer.appendChild(newTaskDescription);

        document.getElementById('taskCount').value = taskCount;
        disableDeleteButton();
    }

    function deleteTask() {
        const taskContainer = document.getElementById('task-container');
        if (taskCount > 1) {
            taskContainer.removeChild(taskContainer.lastChild.previousSibling);
            taskContainer.removeChild(taskContainer.lastChild);
            taskCount--;
        }
        document.getElementById('taskCount').value = taskCount;
        disableDeleteButton();
    }
</script>

</html>

<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $pid = filter_var($_POST["pid"], FILTER_SANITIZE_STRING);
    echo '<script>document.getElementById("pid2nd").value = "' . $pid . '";</script>';
    $sql = "SELECT * FROM project WHERE pid = '$pid'";
    echo '<script>document.getElementById("pid").value = "' . $pid . '";</script>';
    $result = mysqli_query($connection, $sql);
    if (mysqli_num_rows($result) > 0) {
        echo '<script>document.getElementById("projectDetailsContainer").removeAttribute("style");</script>';
        $row = mysqli_fetch_assoc($result);
        $noOfTasks = $row['noOfTasks'];
        for ($i = 1; $i < $noOfTasks; $i++) {
            echo '<script>addTask();</script>';
        }
        echo '<script>document.getElementById("pname").value = "' . $row['pname'] . '";</script>';
        echo '<script>document.getElementById("pdis").value = "' . $row['pdis'] . '";</script>';
        echo '<script>document.getElementById("projectCategory").value = "' . $row['pcategory'] . '";</script>';
        echo '<script>document.getElementById("sdate").value = "' . $row['sdate'] . '";</script>';
        echo '<script>document.getElementById("edate").value = "' . $row['edate'] . '";</script>';


        $sql = "SELECT * FROM tasks WHERE pid = '$pid'";
        $result = mysqli_query($connection, $sql);
        for ($i = 0; $i < $noOfTasks; $i++) {
            $row = mysqli_fetch_assoc($result);
            echo '<script>document.getElementById("task' . ($i + 1) . '").value = "' . $row['taskName'] . '";</script>';
            echo '<script>document.getElementById("t' . ($i + 1) . 'dis").value = "' . $row['discription'] . '";</script>';
        }

    } else {
        $em = "Failed to find project data.";
        echo "<script>window.location.href='./edit-project.php?projectupdatestatus=error&msg=$em';</script>";
    }
}
include '../footer.php';
?>