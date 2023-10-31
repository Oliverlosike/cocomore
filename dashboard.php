<?php
session_start();

// Check if the user is authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Establish a database connection
$db = new mysqli('localhost', 'root', '', 'tasks.db');

if ($db->connect_error) {
    die("Database connection failed: " . $db->connect_error);
}

// Fetch user information from the database based on the user_id stored in the session
$user_id = $_SESSION['user_id'];

$query = "SELECT * FROM users WHERE user_id=?";
$stmt = $db->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
    $full_name = $user['full_name'];
    $email = $user['email'];
}

// Query the tasks associated with the user
$query = "SELECT * FROM tasks WHERE user_id=?";
$stmt = $db->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$tasks_result = $stmt->get_result();

// Create an array to store the tasks
$tasks = array();

while ($task = $tasks_result->fetch_assoc()) {
    $tasks[] = $task;
}

$stmt->close();
$db->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #007BFF;
            color: #fff;
            text-align: left;
            padding: 10px 20px; /* Modified padding */
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .task-form {
            padding: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
        }

        input[type="text"],
        textarea,
        select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        select {
            height: 35px;
        }

        button {
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #007BFF;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .actions {
            text-align: center;
        }

        .actions a {
            margin: 0 5px;
            text-decoration: none;
            color: #007BFF;
        }

        .actions a:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
    <header>
        <h1><a href="dashboard.php" style="color: #fff; text-decoration: none;">Dashboard</a></h1>
        <nav>
            <a href="about.php" style="text-decoration: none;">About Us</a> 
        </nav>
    </header>

    <div class="container">
        <section>
            <h2>Create a New Task</h2>
            <form method="post" action="create_task.php" class="task-form">
                <div class="form-group">
                    <label for="task_name">Task Name:</label>
                    <input type="text" id="task_name" name="task_name" required>
                </div>

                <div class "form-group">
                    <label for="task_description">Task Description:</label>
                    <textarea id="task_description" name="task_description" required></textarea>
                </div>

                <div class="form-group">
                    <label for="status">Status:</label>
                    <select id="status" name="status">
                        <option value="in_progress">In Progress</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>

                <div class="form-group">
                    <button type="submit">Create Task</button>
                </div>
            </form>
        </section>

        <section>
            <h2>Task Management</h2>
            <table>
                <thead>
                    <tr>
                        <th>Task Name</th>
                        <th>Task Description</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($tasks as $task) {
                        echo "<tr>";
                        echo "<td>{$task['task_name']}</td>";
                        echo "<td>{$task['task_description']}</td>";
                        echo "<td>{$task['status']}</td>";
                        echo "<td class='actions'>";
                        echo "<a href='edit_task.php?task_id={$task['task_id']}'>Edit</a> | ";
                        echo "<a href='view_task.php?task_id={$task['task_id']}'>View</a> | ";
                        echo "<a href='delete_task.php?task_id={$task['task_id']}'>Delete</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </div>
</body>
</html>
