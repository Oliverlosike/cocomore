<?php
session_start();

// Check if the user is authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the required fields are set and not empty
    if (isset($_POST['task_id'], $_POST['task_name'], $_POST['task_description'], $_POST['status'])) {
        $task_id = $_POST['task_id'];
        $task_name = $_POST['task_name'];
        $task_description = $_POST['task_description'];
        $status = $_POST['status'];
        
        // Perform the task update in the database
        $db = new mysqli('localhost', 'root', '', 'tasks.db');
        
        if ($db->connect_error) {
            die("Database connection failed: " . $db->connect_error);
        }
        
        $user_id = $_SESSION['user_id'];
        $query = "UPDATE tasks SET task_name=?, task_description=?, status=? WHERE user_id=? AND task_id=?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("sssii", $task_name, $task_description, $status, $user_id, $task_id);
        
        if ($stmt->execute()) {
            // Task updated successfully
            header("Location: dashboard.php");
            exit();
        } else {
            // Task update failed
            echo "Task update failed. Please try again.";
        }
        
        $stmt->close();
        $db->close();
    } else {
        echo "Invalid request. Please provide all required fields.";
    }
} else {
    echo "Invalid request method.";
}
?>
