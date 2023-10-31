<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if the user is not authenticated
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $task_name = $_POST['task_name'];
    $task_description = $_POST['task_description'];
    $status = $_POST['status'];

    // Establish a database connection
    $db = new mysqli('localhost', 'root', '', 'tasks.db');

    // Insert the new task into the database
    $query = "INSERT INTO tasks (user_id, task_name, task_description, status) VALUES (?, ?, ?, ?)";
    $stmt = $db->prepare($query);
    $stmt->bind_param("isss", $user_id, $task_name, $task_description, $status);

    if ($stmt->execute()) {
        // Task created successfully, you can add a success message or redirect to the dashboard
        header("Location: dashboard.php");
        exit();
    } else {
        // Handle the error if the task creation fails
        echo "Error creating task: " . $stmt->error;
    }

    // Close the database connection
    $stmt->close();
    $db->close();
}
