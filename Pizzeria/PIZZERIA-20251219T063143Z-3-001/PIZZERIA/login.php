<?php
session_start();
include "pizzeria_db.php"; // Make sure this connects to your database

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username_or_email = trim($_POST['username_or_email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username_or_email) || empty($password)) {
        $error = "Please enter both username/email and password.";
    } else {
        // Look for user by username or email
        $stmt = mysqli_prepare(
            $conn,
            "SELECT id, username, email, password FROM users WHERE username = ? OR email = ? LIMIT 1"
        );
        mysqli_stmt_bind_param($stmt, "ss", $username_or_email, $username_or_email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($user = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $user['password'])) {
                // Password correct → start session
                $_SESSION['logged_in'] = true;
                $_SESSION['username'] = $user['username'];
                $_SESSION['user_id']  = $user['id'];

                header("Location: home.php");
                exit;
            } else {
                $error = "Incorrect password.";
            }
        } else {
            $error = "User not found.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>
<style>
body { font-family: Arial; 
    display: flex; 
    justify-content: center; 
    align-items: center; 
    min-height: 100vh; 
    background: url('pizza_bg.jpg') no-repeat center center/cover;
}
.login-container { 
    background: #fff; 
    padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.2); width: 350px; text-align: center; }
.login-container input { width: 100%; padding: 10px; margin: 8px 0; border-radius: 6px; border: 1px solid #ccc; }
.login-container button { width: 100%; padding: 10px; border: none; background: #b8432e; color: #fff; border-radius: 25px; cursor: pointer; font-size: 16px; }
.login-container button:hover { background: #a03827; }
.error { color: red; margin-bottom: 10px; }
</style>
</head>
<body>

<div class="login-container">
    <h2>Login</h2>
    <?php if(!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="POST" action="">
        <input type="text" name="username_or_email" placeholder="Username or Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
    <p style="margin-top:10px;">Don't have an account? <a href="signup.php">Sign Up</a></p>
</div>

</body>
</html>
