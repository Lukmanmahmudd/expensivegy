<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kanawa_taxi_db";
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['login-submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the user exists
    $sql = "SELECT * FROM admin_users WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User found, set session and redirect
        $_SESSION['email'] = $email;
        header("Location: dashboard.php");
        exit();
    } else {
        // User not found, show error
        $error = "Invalid email or password.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kanawa Taxi Admin Login</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,600,700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100vw;
            height: 100vh;
            background: linear-gradient(to right, #2c3e50, #bdc3c7);
            font-family: 'Montserrat', sans-serif;
        }

        .login-container {
            width: 500px;
            padding: 3rem 5rem;
            background-color: white;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .login-container h2 {
            font-size: 24px;
            font-weight: 700;
            color: #2c3e50;
            text-align: center;
            margin-bottom: 3rem;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            color: #34495e;
            margin-bottom: 0.5rem;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            margin-bottom: 1.5rem;
            border: 1px solid #bdc3c7;
            border-radius: 4px;
            font-size: 14px;
            color: #34495e;
        }

        .form-group input:focus {
            border-color: #2980b9;
            outline: none;
        }

        .form-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .form-check {
            display: flex;
            align-items: center;
        }

        .form-check input {
            margin-right: 8px;
        }

        .form-check label {
            font-size: 14px;
            color: #34495e;
        }

        .btn {
            width: 100%;
            margin-top: 1.5rem;
            padding: 12px;
            background-color: #2980b9;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #1c5986;
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 1rem;
        }

        .go-back {
            font-size: 14px;
            color: #2980b9;
            text-decoration: none;
        }

        .go-back:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Admin Login</h2>
    <form action="login.php" method="post">
        <?php
            if (isset($error)) {
                echo '<div class="error">'.$error.'</div>';
            }
        ?>
        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" placeholder="admin@example.com" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="********" required>
        </div>
        <div class="form-footer">
            <div class="form-check">
                <input type="checkbox" id="rememberMe" name="rememberMe">
                <label for="rememberMe">Remember me</label>
            </div>
            <a href="index.html" class="go-back">Go back?</a>
        </div>
        <button type="submit" class="btn" name="login-submit">Sign In</button>
    </form>
</div>

</body>
</html>
