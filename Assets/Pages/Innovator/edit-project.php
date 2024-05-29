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

?>

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
        <div class="card bg-dark border-3 border-white mt-4">
            <div class="card-body">
                <div class="form-floating mb-3 mt-3">
                    <select class="form-select mt-3" required name="pID" id="pID">
                        <?php
                        // $sql = "SELECT * FROM projects WHERE createby='$username'";
                        // $result = mysqli_query($connection, $sql);
                        // if (mysqli_num_rows($result) > 0) {
                        //     while ($row = mysqli_fetch_assoc($result)) {
                        //         echo "<option>" . $row['pid'] . "</option>";
                        //     }
                        // } else 
                        {
                            echo "<option disabled>--Projects not found--</option>";
                        }
                        ?>
                        <!-- <option value="Innovator">Innovator</option>
                        <option value="Supplier">Supplier</option>
                        <option value="Lawyer">Lawyer</option>
                        <option value="Marketing Manager">Marketing Manager</option> -->
                    </select>
                    <label for="pID">Select Project</label>
                </div>
            </div>
        </div>
        <div class="card bg-dark border-3 border-white mt-4">
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
                    </script>
                    
    </div >

</body >

</html >