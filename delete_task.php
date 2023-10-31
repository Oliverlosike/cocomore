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
    
    // Delete the task from the database based on the task_id
    $db = new mysqli('localhost', 'root', '', 'tasks.db');
    
    if ($db->connect_error) {
        die("Database connection failed: " . $db->connect_error);
    }
    
    $user_id = $_SESSION['user_id'];
    $query = "DELETE FROM tasks WHERE user_id=? AND task_id=?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("ii", $user_id, $task_id);
    
    if ($stmt->execute()) {
        // Task deleted successfully, you can redirect to the dashboard or another page
        header("Location: dashboard.php");
    } else {
        echo "Task deletion failed.";
    }
    
    $stmt->close();
    $db->close(); // Corrected this line
}
