<?php
session_start();
include 'pizzeria_db.php';
include 'header.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$message = '';

// Fetch user data
$stmt = $conn->prepare("SELECT username, email, phone, address FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $address = $_POST['address'] ?? '';

    if ($username && $email) {
        $update_stmt = $conn->prepare("UPDATE users SET username=?, email=?, phone=?, address=? WHERE id=?");
        $update_stmt->bind_param("ssssi", $username, $email, $phone, $address, $user_id);
        if ($update_stmt->execute()) {
            $message = "Profile updated successfully!";
            $user['username'] = $username;
            $user['email'] = $email;
            $user['phone'] = $phone;
            $user['address'] = $address;
        } else {
            $message = "Failed to update profile.";
        }
    } else {
        $message = "Username and email cannot be empty.";
    }
}

// Fetch user's order history
$order_stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
$order_stmt->bind_param("i", $user_id);
$order_stmt->execute();
$orders_result = $order_stmt->get_result();
?>

<style>
body {
    background: #fdf6f0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.profile-section {
    max-width: 1000px;
    margin: 40px auto;
    padding: 0 20px;
    display: flex;
    gap: 40px;
    flex-wrap: wrap;
}

.profile-left, .profile-right {
    flex: 1;
    min-width: 320px;
}

.profile-header {
    font-size: 28px;
    color: #7a1f12;
    margin-bottom: 20px;
    border-bottom: 2px solid #7a1f12;
    display: inline-block;
    padding-bottom: 5px;
}

.profile-form label {
    display: block;
    margin: 10px 0 5px;
    font-weight: bold;
    color: #333;
}

.profile-form input,
.profile-form textarea {
    width: 100%;
    padding: 8px 10px;
    margin-bottom: 12px;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 14px;
}

.update-btn {
    background: #7a1f12;
    color: #fff;
    padding: 12px 28px;
    border: none;
    border-radius: 25px;
    cursor: pointer;
    font-size: 14px;
    transition: 0.3s;
}

.update-btn:hover {
    background: #a93226;
}

.profile-message {
    padding: 10px 15px;
    margin-bottom: 15px;
    border-radius: 8px;
    text-align: center;
    color: #fff;
}

.profile-message.success {
    background: #4caf50;
}

.profile-message.error {
    background: #f44336;
}

/* Shopee-style order history */
.order-history h3 {
    font-size: 24px;
    color: #7a1f12;
    margin-bottom: 15px;
}

.order-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    padding: 15px 20px;
    margin-bottom: 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: 0.3s;
}

.order-card:hover {
    box-shadow: 0 6px 18px rgba(0,0,0,0.12);
}

.order-info {
    display: flex;
    flex-direction: column;
}

.order-info span {
    margin-bottom: 4px;
    font-size: 14px;
    color: #555;
}

.view-btn {
    padding: 6px 14px;
    border-radius: 5px;
    background: #3498db;
    color: #fff;
    text-decoration: none;
    font-size: 14px;
    transition: 0.3s;
}

.view-btn:hover {
    background: #2980b9;
}

@media (max-width: 768px) {
    .profile-section {
        flex-direction: column;
    }
}
.logout-btn {
    background: #7a1f12;
    color: #fff;
    padding: 12px 28px;
    border: none;
    border-radius: 25px;
    cursor: pointer;
    font-size: 14px;
    transition: 0.3s;
}

.logout-btn:hover {
    background: #a93226;
}

</style>

<section class="profile-section">
    <!-- Left: Profile info -->
    <div class="profile-left">
        <div class="profile-header">Your Profile</div>

        <?php if($message): ?>
            <div class="profile-message <?= strpos($message, 'successfully') !== false ? 'success' : 'error' ?>">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="profile-form">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" value="<?= htmlspecialchars($user['username']) ?>" required>

            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email']) ?>" required>

            <label for="phone">Phone Number</label>
            <input type="text" name="phone" id="phone" value="<?= htmlspecialchars($user['phone']) ?>">

            <label for="address">Address</label>
            <textarea name="address" id="address" rows="3"><?= htmlspecialchars($user['address']) ?></textarea>

            <button type="submit" class="update-btn">Update Profile</button>
    <a href="logout.php" class="logout-btn">Logout</a>
</div>

        </form>
    </div>

    <!-- Right: Shopee-style Order history -->
    <div class="profile-right">
        <div class="order-history">
            <h3>Your Orders</h3>

            <?php if ($orders_result && $orders_result->num_rows > 0): ?>
                <?php while($order = $orders_result->fetch_assoc()): ?>
                    <div class="order-card">
                        <div class="order-info">
                            <span><strong>Order ID:</strong> <?= $order['id'] ?></span>
                            <span><strong>Total:</strong> ₱<?= number_format($order['total'], 2) ?></span>
                            <span><strong>Date:</strong> <?= $order['created_at'] ?></span>
                        </div>
                        <a href="order_detail.php?id=<?= $order['id'] ?>" class="view-btn">View</a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>You haven't placed any orders yet.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>
