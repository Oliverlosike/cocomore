<?php
session_start();

// Check if the user is authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if a task ID is provided in the query string
if (isset($_GET['task_id'])) {
    $task_id = $_GET['task_id'];
    
    // Retrieve the task details from the database based on the task_id
    $db = new mysqli('localhost', 'root', '', 'tasks.db');
    
    if ($db->connect_error) {
        die("Database connection failed: " . $db->connect_error);
    }
    
    $user_id = $_SESSION['user_id'];
    $query = "SELECT * FROM tasks WHERE user_id=? AND task_id=?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("ii", $user_id, $task_id);
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $task = $result->fetch_assoc();
            // Display the task details here (read-only)
        } else {
            echo "Task not found.";
        }
    } else {
        echo "Query execution failed: " . $stmt->error;
    }
    
    $stmt->close();
    $db->close();
} else {
    echo "Task ID is not provided.";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Task</title>
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
            text-align: center;
            padding: 10px 0;
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

        section {
            padding: 20px;
        }

        h2 {
            color: #007BFF;
        }

        p {
            margin: 0;
            margin-bottom: 10px;
        }

        footer {
            text-align: center;
            background-color: #007BFF;
            color: #fff;
            padding: 10px 0;
        }
    </style>
</head>
<body>
    <header>
        <h1>View Task</h1>
    </header>

    <nav>
        <!-- Add navigation links as needed -->
    </nav>

    <section>
        <!-- Display the task details here (read-only) -->
        <?php
        if (isset($task)) {
            echo "<h2>Task Details</h2>";
            echo "<p>Task Name: " . $task['task_name'] . "</p>";
            echo "<p>Task Description: " . $task['task_description'] . "</p>";
            echo "<p>Status: " . $task['status'] . "</p>";
        }
        ?>

         <a href="dashboard.php">Back to Dashboard</a>
    </section>

    <footer>
        &copy; 2023 Cocomore
       
    </footer>
</body>
</html>

