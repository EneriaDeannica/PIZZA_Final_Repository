<?php
session_start();
include "pizzeria_db.php";
include 'header.php';

// Fetch admin info
$stmt = $conn->prepare("SELECT username, email FROM users WHERE id=?");
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();

// Handle updates
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';

    if ($username && $email) {
        $update = $conn->prepare("UPDATE users SET username=?, email=? WHERE id=?");
        $update->bind_param("ssi", $username, $email, $admin_id);
        if ($update->execute()) {
            $message = "Profile updated successfully!";
            $admin['username'] = $username;
            $admin['email'] = $email;
        } else {
            $message = "Update failed!";
        }
    } else {
        $message = "Fields cannot be empty!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Profile</title>
<style>
body { font-family: Arial; background:#f9f9f9; padding:20px;}
.profile { max-width:500px; margin:auto; background:#fff; padding:30px; border-radius:15px; box-shadow:0 5px 15px rgba(0,0,0,0.1);}
input { width:100%; padding:10px; margin:10px 0; border-radius:6px; border:1px solid #ccc;}
button { background:#7a1f12; color:#fff; padding:12px 20px; border:none; border-radius:25px; cursor:pointer;}
button:hover { background:#a93226; }
.message { text-align:center; padding:10px; margin-bottom:10px; border-radius:5px; color:#fff; }
.success { background:#4caf50; }
.error { background:#f44336; }
.logout-btn { display:block; text-align:center; margin-top:15px; text-decoration:none; color:#fff; background:#b8432e; padding:8px 16px; border-radius:5px;}
.logout-btn:hover { background:#a03827; }
</style>
</head>
<body>

<div class="profile">
    <h2>Admin Profile</h2>

    <?php if($message): ?>
        <div class="message <?= strpos($message,'success')!==false?'success':'error' ?>"><?= $message ?></div>
    <?php endif; ?>

    <form method="POST">
        <label>Username</label>
        <input type="text" name="username" value="<?= htmlspecialchars($admin['username']) ?>" required>

        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($admin['email']) ?>" required>

        <button type="submit">Update Profile</button>
    </form>

    <a href="logout.php" class="logout-btn">Logout</a>
</div>

</body>
</html>
