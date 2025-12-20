<?php
session_start();
include "pizzeria_db.php";
include "header.php";

// Redirect if not logged in
if (!isset($_SESSION['user_id']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

/* ================= FETCH USER INFO ================= */
$stmt = mysqli_prepare($conn, "SELECT username, email, phone, address FROM users WHERE user_id = ? LIMIT 1");
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$user) {
    echo "User not found.";
    exit;
}

/* ================= UPDATE ACCOUNT ================= */
$success = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_account'])) {
    $stmt = mysqli_prepare($conn, "UPDATE users SET username=?, email=?, phone=?, address=? WHERE user_id=?");
    mysqli_stmt_bind_param($stmt, "ssssi", $_POST['username'], $_POST['email'], $_POST['phone'], $_POST['address'], $user_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    $success = "Account updated successfully!";

    // Refresh user data
    $stmt = mysqli_prepare($conn, "SELECT username, email, phone, address FROM users WHERE user_id=?");
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $user = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Account</title>
<style>
* { box-sizing: border-box; font-family: Arial, sans-serif; }

.account-layout .main-content {
    margin-left: 260px;
}

.account-wrapper {
    max-width: 1000px;
    margin: 80px auto 0; /* 👈 pushes it lower */
    background: #e5e5e5;
    border-radius: 20px;
    display: flex;
    flex-wrap: wrap;
}
/* Sidebar */
.sidebar {
    background: #7b1f1f;
    color: white;
    width: 250px;
    padding: 30px;
    border-radius: 20px 0 0 20px;
    text-align: center;
}

.sidebar img {
    width: 100px;
    margin-bottom: 15px;
}

.sidebar h3 {
    margin-bottom: 30px;
}

.sidebar a {
    display: block;
    color: white;
    text-decoration: none;
    margin: 15px 0;
    font-weight: bold;
}

.sidebar a:hover {
    text-decoration: underline;
}

/* Main content */
.content {
    flex: 1;
    padding: 40px;
}

.content h2 {
    margin-bottom: 20px;
}
.sidebar a:hover { 
    background: rgba(255,255,255,0.2); 
}
.sidebar .logout { 
    margin-top: 165px;
    background: #c14a1b; 
    padding:10px; 
    border-radius: 20px;
}

form input, form textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border-radius: 10px;
    border: 1px solid #ccc;
}

button {
    background: #c14a1b;
    color: white;
    border: none;
    padding: 12px 20px;
    border-radius: 25px;
    cursor: pointer;
}

button:hover {
    background: #a63d16;
}

.success {
    color: green;
    margin-bottom: 10px;
}

/* Responsive */
@media (max-width: 768px) {
    .sidebar {
        width: 100%;
        border-radius: 20px 20px 0 0;
    }

}
</style>
</head>
<body>

<div class="account-wrapper">


    <!-- Sidebar -->
    <div class="sidebar">
        <h3 style="cursor: default;"><?= "Hi! " . htmlspecialchars($user['username']) ?></h3>
        <a href="cus_account.php">Account</a>
        <a href="logout.php" class="logout">Logout</a>
    </div>


    <!-- Main Content -->
    <div class="content">
        <h2>Account Information</h2>

        <?php if ($success): ?>
            <div class="success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <form method="POST">
            <input type="hidden" name="update_account">
            <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
            <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>">
            <textarea name="address"><?= htmlspecialchars($user['address']) ?></textarea>

            <button type="submit">Update Account</button>
        </form>
    </div>

</div>

</body>
</html>

<?php include 'footer.php'; ?>
