<?php
session_start();
include "pizzeria_db.php"; // Make sure this file has your DB connection

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $phone    = trim($_POST['phone'] ?? '');
    $address  = trim($_POST['address'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm_password'] ?? '';

    // Validation
    if (empty($username) || empty($email) || empty($password)) {
        $error = "Please fill in all required fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif ($password !== $confirm) {
        $error = "Passwords do not match.";
    }

    // If no error, insert into database
    if (empty($error)) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);

        $stmt = mysqli_prepare(
            $conn,
            "INSERT INTO users (username, email, phone, address, password) VALUES (?, ?, ?, ?, ?)"
        );

        mysqli_stmt_bind_param($stmt, "sssss", $username, $email, $phone, $address, $hashed);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;

            header("Location: home.php");
            exit;
        } else {
            $error = "Signup failed. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pizza Sign Up</title>
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }

  body {
      background: url('pizza_bg.jpg') no-repeat center center/cover;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
  }

  .signup-container {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 12px;
      width: 400px;
      max-width: 90%;
      padding: 40px 30px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.3);
      text-align: center;
  }

  .signup-container h2 {
      color: #b8432e;
      margin-bottom: 25px;
      font-size: 28px;
      font-weight: bold;
  }

  .signup-container input[type="text"],
  .signup-container input[type="email"],
  .signup-container input[type="password"] {
      width: 100%;
      padding: 12px;
      margin: 8px 0;
      border-radius: 10px;
      border: 2px solid #b8432e;
      font-size: 14px;
  }

  .signup-btn {
      background: #b8432e;
      color: #fff;
      border: none;
      padding: 12px;
      width: 100%;
      border-radius: 25px;
      cursor: pointer;
      font-size: 16px;
      margin: 15px 0;
      transition: all 0.2s ease;
  }

  .signup-btn:hover {
      background: #a03827;
      transform: translateY(-2px);
  }

  .account-question {
      font-size: 14px;
      color: #505050;
  }

  .account-question a {
      color: #b8432e;
      font-weight: bold;
      text-decoration: none;
  }

  .error {
      color: red;
      font-weight: bold;
      margin-bottom: 10px;
  }
</style>
</head>
<body>

<div class="signup-container">
    <h2>Create Your Account</h2>

    <?php if(!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <input type="text" name="username" placeholder="Username" required>

        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="phone" placeholder="Phone Number" required>
        <input type="text" name="address" placeholder="Address" required>

        <input type="password" name="password" placeholder="Password" id="password" required>
        <input type="password" name="confirm_password" placeholder="Confirm Password" id="confirm_password" required>
        <small id="pass-match" style="display:block; margin-bottom:8px; color:green;"></small>

        <button type="submit" class="signup-btn">Sign Up</button>
        <p class="account-question">
            Already have an account? <a href="login.php">Login</a>.
        </p>
    </form>
</div>

<script>
const password = document.getElementById('password');
const confirmPassword = document.getElementById('confirm_password');
const passMatch = document.getElementById('pass-match');

function checkPasswordMatch() {
    if (confirmPassword.value === '') {
        passMatch.textContent = '';
        return;
    }
    if (password.value === confirmPassword.value) {
        passMatch.style.color = 'green';
        passMatch.textContent = "Passwords match!";
    } else {
        passMatch.style.color = 'red';
        passMatch.textContent = "Passwords do not match!";
    }
}

password.addEventListener('input', checkPasswordMatch);
confirmPassword.addEventListener('input', checkPasswordMatch);
</script>

</body>
</html>
