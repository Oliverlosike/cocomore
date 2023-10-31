<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Establish a database connection
    $db = new mysqli('localhost', 'root', '', 'tasks.db');

    // Check for a database connection error
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    // Prepare and execute an INSERT query to add the new user to the database
    $query = "INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)";
    $stmt = $db->prepare($query);
    $stmt->bind_param("sss", $full_name, $email, $password);

    if ($stmt->execute()) {
        // Registration successful, redirect to the login page after a delay
        echo '<script>setTimeout(function() { window.location = "login.php"; }, 2000);</script>';
        echo 'Registration successful. Redirecting to the login page...';
        exit();
    } else {
        // Registration failed, you can display an error message
        echo "Registration failed.";
    }

    // Close the database connection
    $stmt->close();
    $db->close();
}
?>
