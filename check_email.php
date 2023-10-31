<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Establish a database connection
    $db = new mysqli('localhost', 'root', '', 'tasks.db');

    // Check for a database connection error
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    // Query the database to check if the email exists
    $query = "SELECT COUNT(*) as count FROM users WHERE email=?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $count = $row['count'];

        if ($count > 0) {
            // Email already exists
            echo 'exists';
        } else {
            // Email is available
            echo 'available';
        }
    } else {
        // Something went wrong with the database query
        echo 'error';
    }

    // Close the database connection
    $stmt->close();
    $db->close();
} else {
    // If this script is accessed by a method other than POST, handle it accordingly
    echo 'invalid';
}
?>
