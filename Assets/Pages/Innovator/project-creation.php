<?php
session_start();
if (isset($_SESSION['username']) || isset($_SESSION['role'])) {
    $username = $_SESSION['username'];
    $role = $_SESSION['role'];
    if($role != 'Innovator'){
        echo "<script>window.location.href='../../../index.php';</script>";
        exit();
    }
} else {
    // header("Location: ../../../index.php");
    echo "<script>window.location.href='../../../index.php';</script>";
    exit();
}

include '../dbconnection.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IMS - Create Project</title>
</head>

<body class="bg-dark text-white">
    <?php include 'innovator-nav.php'; ?>

    <div class="container mt-5 text-white">
        <h2 class="text-center">Create Project</h2>
        <form action="project-creation.php" method="POST">
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
                    <input type="text" class="form-control" id="task1" placeholder="Enter Task 1" name="task1" required>
                    <label for="task1" class="text-dark">Task 1</label>

                </div>
            </div>
            <button class="btn btn-primary" onclick="addTask()">Add Task</button>
            <button class="btn btn-danger delete-task" onclick="deleteTask()">Delete Task</button>

            <script>
                let taskCount = 1;
                disableDeleteButton();

                function disableDeleteButton() {
                    if (taskCount == 1) {
                        document.querySelector('.delete-task').disabled = true;
                    } else if (taskCount > 1) {
                        document.querySelector('.delete-task').disabled = false;
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
                    taskContainer.appendChild(newTask);

                    disableDeleteButton();
                }

                function deleteTask() {
                    const taskContainer = document.getElementById('task-container');
                    if (taskCount > 1) {
                        taskContainer.removeChild(taskContainer.lastChild);
                        taskCount--;
                    }
                    disableDeleteButton();
                }
            </script>

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
                        <input type="date" class="form-control" id="sdate" name="sdate" required
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
            <button type="submit" class="btn btn-primary col-md-12">Create Project</button>
        </form>
    </div>
    <?php include '../footer.php' ?>
</body>

</html>

<?php
// $taskCount = "<script>taskCount</script>";
    ?>