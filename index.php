<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>To do list</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body>
<div class="container w-50 mx-auto">
    <h2 class="mt-5 mb-5 text-center">To Do List</h2>
    <form method="post" class="mb-5">
        <label for="task">Enter task:</label>
        <input type="text" name="task" placeholder="text" required>
        <input type="submit" name="submit" value="Add Task">
    </form>

    <?php
    session_start();

    if (!isset($_SESSION["taskList"])) {
        $_SESSION["taskList"] = [];
    }

    if(isset($_POST["submit"])) {
        $task = array(
            "description" => $_POST["task"],
            "status" => "Unready"
        );

        $_SESSION["taskList"][] = $task;
    }

    if(count($_SESSION["taskList"]) > 0) {
        echo "<h3>Unready tasks:</h3>";
        echo "<table class='table'>";
        echo "<tr><th>Task</th><th>Status</th><th>Action</th></tr>";

        foreach($_SESSION["taskList"] as $key => $task) {
            if($task["status"] == "Unready") {
                echo "<tr>";
                echo "<td>".$task["description"]."</td>";
                echo "<td>".$task["status"]."</td>";
                echo "<td>
                        <form method='post'>
                            <input type='hidden' name='taskId' value='".$key."'>
                            <input type='submit' name='ready' value='Ready' class='btn btn-success'>
                            <input type='submit' name='delete' value='Delete' class='btn btn-danger'>
                        </form>
                    </td>";
                echo "</tr>";
            }
        }
        echo "</table>";

        echo "<form method='post'>";
        echo "<input type='submit' name='readyAll' value='Ready All Tasks' class='btn btn-success mr-2'>";
        echo "<input type='submit' name='deleteTasks' value='Delete All Tasks' class='btn btn-danger'>";
        echo "</form>";

        echo "<h3 class='mt-5'>Ready Tasks:</h3>";
        echo "<table class='table'>";
        echo "<tr><th>Task</th><th>Status</th><th>Action</th></tr>";

        foreach($_SESSION["taskList"] as $key => $task) {
            if($task["status"] == "Ready") {
                echo "<tr>";
                echo "<td>".$task["description"]."</td>";
                echo "<td>".$task["status"]."</td>";
                echo "<td>
                <form method='post'>
                    <input type='hidden' name='taskId' value='".$key."'>
                    <input type='submit' name='unready' value='Unready' class='btn btn-secondary'>
                    <input type='submit' name='deleteReadies' value='Delete' class='btn btn-danger'>
                </form>
            </td>";
                echo "</tr>";
            }
        }
        echo "</table>";
    }

    if(isset($_POST["ready"])) {
        $taskId = $_POST["taskId"];
        $_SESSION["taskList"][$taskId]["status"] = "Ready";
    }

    if(isset($_POST["delete"])) {
        $taskId = $_POST["taskId"];
        unset($_SESSION["taskList"][$taskId]);
    }

    if (isset($_POST["deleteTasks"])) {
        foreach ($_SESSION["taskList"] as $key => $task) {
            if ($task["status"] == "Unready") {
                unset($_SESSION["taskList"][$key]);
            }
        }
    }

    if(isset($_POST["deleteReadies"])) {
        $taskId = $_POST["taskId"];
        unset($_SESSION["taskList"][$taskId]);
    }

    if(isset($_POST["readyAll"])) {
        foreach($_SESSION["taskList"] as $key => $task) {
            $_SESSION["taskList"][$key]["status"] = "Ready";
        }
        $_SESSION["taskList"] = array_values($_SESSION["taskList"]);
    }

    if (isset($_POST["unready"])) {
        $taskId = $_POST["taskId"];
        $_SESSION["taskList"][$taskId]["status"] = "Unready";
    }
    ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>