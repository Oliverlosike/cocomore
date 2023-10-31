<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Establish a database connection
    $db = new mysqli('localhost', 'root', '', 'tasks.db');

    // Check for a database connection error
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    // Query the database to retrieve the user's hashed password based on their email
    $query = "SELECT user_id, password FROM users WHERE email=?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $hashed_password = $user['password'];

        // Verify if the password matches the hashed password
        if (password_verify($password, $hashed_password)) {
            // Start a session and set a session variable for authentication
            session_start();
            $_SESSION['user_id'] = $user['user_id'];

            // Redirect to the dashboard after successful login
            header("Location: dashboard.php");
            exit();
        } else {
            $login_error = "Incorrect password.";
        }
    } else {
        $login_error = "User not found.";
    }

    // Close the database connection
    $stmt->close();
    $db->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login Page</title>
    <link rel="stylesheet" type="text/css" href="style.css">
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
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        label {
            display: block;
            font-weight: bold;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-bottom: 15px;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        div.error {
            color: red;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Login Page</h1>
    </header>

    <div class="container">
        <form method="POST" action="">
            <label for="email">Email:</label>
            <input type="email" name="email" required>
            <br>
            <label for="password">Password:</label>
            <input type="password" name="password" required>
            <br>
            <input type="submit" value="Login">
        </form>
        <?php
        // Display login errors, if any
        if (isset($login_error)) {
            echo '<div class="error">' . $login_error . '</div>';
        }
        ?>
    </div>
</body>
</html>
