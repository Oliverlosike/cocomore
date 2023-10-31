<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Registration</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        /* Center the header */
        header {
            background-color: #007BFF;
            color: #fff;
            text-align: center;
            padding: 10px 0;
        }

        /* Style the navigation links */
        nav ul {
            display: flex;
            list-style: none;
            padding: 0;
            justify-content: center;
        }

        nav ul li {
            margin: 0 15px;
        }

        nav ul li a {
            text-decoration: none;
            color: #007BFF;
        }

        /* Center the registration form */
        .registration-form {
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

        .form-group label {
            display: block;
            font-weight: bold;
        }

        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="password"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .form-group input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }

        .form-group input[type="submit"]:hover {
            background-color: #0056b3;
        }

        /* Center the footer */
        footer {
            text-align: center;
            background-color: #333;
            color: #fff;
            padding: 10px 0;
        }
    </style>
</head>
<body>
    <header>
        <h1>User Registration</h1>
    </header>

    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <?php
            // Check if the user is logged in
            session_start();
            if (isset($_SESSION['user_id'])) {
                echo '<li><a href="dashboard.php">Dashboard</a></li>';
            } else {
                echo '<li><a href="login.php">Login</a></li>';
            }
            ?>
        </ul>
    </nav>

    <section class="registration-form">
        <h2>Registration Form</h2>
        <form method="post" action="register_process.php">
            <div class="form-group">
                <label for="full_name">Full Name:</label>
                <input type="text" id="full_name" name="full_name" required />
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required />
                <span id="email_status"></span>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required />
            </div>

            <div class="form-group">
                <input type="submit" value="Register" id="register_button" disabled />
            </div>
        </form>
    </section>

    <footer>
        &copy; Cocomore
    </footer>

    <script>
        const emailInput = document.getElementById('email');
        const emailStatus = document.getElementById('email_status');
        const registerButton = document.getElementById('register_button');

        emailInput.addEventListener('input', function () {
            // Check email availability via Ajax
            fetch('check_email.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({ email: emailInput.value }),
            })
                .then(response => response.text())
                .then(data => {
                    if (data === 'available') {
                        emailStatus.textContent = 'Email is available.';
                        emailStatus.style.color = 'green';
                        registerButton.disabled = false;
                    } else {
                        emailStatus.textContent = 'Email is already registered.';
                        emailStatus.style.color = 'red';
                        registerButton.disabled = true;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    </script>
</body>
</html>
