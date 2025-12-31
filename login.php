<?php
session_start();
include "pizzeria_db.php";

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username_or_email = trim($_POST['username_or_email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username_or_email) || empty($password)) {
        $error = "Please enter both username/email and password.";
    } else {

        $stmt = mysqli_prepare(
            $conn,
            "SELECT user_id, username, email, password, role 
             FROM users 
             WHERE username = ? OR email = ? 
             LIMIT 1"
        );

        mysqli_stmt_bind_param($stmt, "ss", $username_or_email, $username_or_email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($user = mysqli_fetch_assoc($result)) {

            if (password_verify($password, $user['password'])) {

                // ✅ SESSION SET (NO DESIGN CHANGE)
                $_SESSION['logged_in'] = true;
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role']; // admin or customer

                // ✅ ALL USERS GO TO HOME
                header("Location: home.php");
                exit;

            } else {
                $error = "Incorrect password.";
            }

        } else {
            $error = "User not found.";
        }

        mysqli_stmt_close($stmt);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- ⚠️ DESIGN UNTOUCHED -->
    <style>
        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: url('pizza_bg.jpg') no-repeat center center/cover;
            position: relative;
        }

        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            z-index: 0;
        }

        .login-container {
            position: relative;
            z-index: 1;
            background: rgba(255, 255, 255, 0.95);
            padding: 40px 30px;
            border-radius: 15px;
            width: 360px;
            max-width: 90%;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        .login-container h2 {
            color: #b8432e;
            margin-bottom: 25px;
            font-size: 28px;
            font-weight: bold;
        }

        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            margin: 10px 0;
            border-radius: 12px;
            border: 2px solid #b8432e;
            font-size: 14px;
            transition: border 0.2s ease;
        }

        .login-container input:focus {
            outline: none;
            border-color: #a03827;
        }

        .login-container button {
            width: 100%;
            padding: 12px;
            margin-top: 15px;
            border: none;
            border-radius: 25px;
            background: #b8432e;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .login-container button:hover {
            background: #a03827;
            transform: translateY(-2px);
        }

        .error {
            color: red;
            font-weight: bold;
            margin-bottom: 12px;
        }

        .login-container p {
            margin-top: 15px;
            font-size: 14px;
            color: #505050;
        }

        .login-container p a {
            color: #b8432e;
            font-weight: bold;
            text-decoration: none;
        }

        .login-container p a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="login-container">
        <h2>Login</h2>

            <?php if (!empty($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

        <form method="POST" action="">
            <input type="text" name="username_or_email" placeholder="Username or Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>

        <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
    </div>

</body>

</html>