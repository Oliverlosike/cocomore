<!DOCTYPE html>
<html>
<head>
    <title>Home Page</title>
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
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        /* Center the H1 heading */
        header h1 {
            margin: 0;
        }

        section {
            text-align: center;
        }

        /* Center the H2 heading */
        h2.centered-h2 {
            text-align: center;
        }

        /* Style the form buttons */
        .form-buttons {
            text-align: center;
        }

        .form-buttons button {
            margin: 10px;
            padding: 10px 20px;
            font-size: 16px;
            background-color: #0074d9;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        /* Footer styles */
        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px 0;
        }

        footer a {
            color: #fff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <header>
        <h1>Welcome to cocomore</h1>
    </header>

    <div class="container">
        <section>
            <h2 class="centered-h2">Task Management System</h2>
            <!-- Your content for the home page goes here -->

            <!-- Form with buttons for registration and login -->
            <div class="form-buttons">
                <button onclick="location.href='register.php'">Register</button>
                <button onclick="location.href='login.php'">Login</button>
            </div>
        </section>
    </div>

    <footer>
        &copy; 2023 Cocomore
    </footer>
</body>
</html>
