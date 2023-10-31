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
    if (!$stmt) {
        die("Error in SQL query: " . $db->error);
    }
    $stmt->bind_param("ii", $user_id, $task_id);
    $stmt->execute();
    if ($stmt->error) {
        die("Error executing SQL query: " . $stmt->error);
    }
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $task = $result->fetch_assoc();

        // Display the task details and provide a form for editing
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Edit Task</title>
            <!-- Add your stylesheets and scripts here -->
        </head>
        <body>
            <header>
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

nav {
    background-color: #333;
    color: #fff;
    padding: 10px 0;
    text-align: center;
}

nav a {
    color: #fff;
    text-decoration: none;
    margin: 0 15px;
}

nav a:hover {
    text-decoration: underline;
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

footer {
    text-align: center;
    background-color: #007BFF;
    color: #fff;
    padding: 10px 0;
}

    </style>

            <section>
                <h2>Edit Task</h2>
                <form method="post" action="update_task.php">
                    <div class="form-group">
                        <label for="task_name">Task Name:</label>
                        <input type="text" id="task_name" name="task_name" value="<?php echo $task['task_name']; ?>" required />
                    </div>

                    <div class="form-group">
                        <label for="task_description">Task Description:</label>
                        <textarea id="task_description" name="task_description" required><?php echo $task['task_description']; ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="status">Status:</label>
                        <select id="status" name="status">
                            <option value="in_progress" <?php if ($task['status'] === 'in_progress') echo 'selected="selected"'; ?>>In Progress</option>
                            <option value="completed" <?php if ($task['status'] === 'completed') echo 'selected="selected"'; ?>>Completed</option>
                        </select>
                    </div>

                    <input type="hidden" name="task_id" value="<?php echo $task['task_id']; ?>">
                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>"> <!-- Store user ID for validation in update_task.php -->

                    
                    <div class="form-group">
                        <button type="submit">Update Task</button>
                    </div>
                </form>
            </section>

            <footer>
                &copy; cocomore
            </footer>
        </body>
        </html>
        <?php
    } else {
        echo "Task not found.";
    }

    $stmt->close();
    $db->close();
} else {
    echo "Task ID is not provided.";
}
?>
