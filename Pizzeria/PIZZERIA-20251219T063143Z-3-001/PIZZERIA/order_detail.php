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

// Get order ID from URL
$order_id = $_GET['id'] ?? 0;

// Fetch order details
$order_stmt = $conn->prepare("SELECT * FROM orders WHERE id = ? AND user_id = ?");
$order_stmt->bind_param("ii", $order_id, $user_id);
$order_stmt->execute();
$order_result = $order_stmt->get_result();
$order = $order_result->fetch_assoc();

if (!$order) {
    echo "<p>Order not found or you don't have permission to view it.</p>";
    include 'footer.php';
    exit;
}

// Fetch order items
$item_stmt = $conn->prepare("SELECT * FROM order_items WHERE order_id = ?");
$item_stmt->bind_param("i", $order_id);
$item_stmt->execute();
$items_result = $item_stmt->get_result();
?>

<style>
.order-detail-section {
    display: flex;
    justify-content: center;
    padding: 50px 20px;
}

.order-card {
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    padding: 30px;
    max-width: 800px;
    width: 100%;
}

.order-card h2 {
    text-align: center;
    color: #7a1f12;
    margin-bottom: 20px;
}

.order-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

.order-table th, .order-table td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
    text-align: center;
    font-size: 14px;
}

.order-table th {
    background: #f2f2f2;
}

.order-table img {
    width: 60px;
    border-radius: 8px;
}

.back-btn {
    display: inline-block;
    background: #7a1f12;
    color: #fff;
    padding: 10px 20px;
    border-radius: 25px;
    text-decoration: none;
    transition: 0.3s;
}

.back-btn:hover {
    background: #a93226;
}

.order-summary {
    text-align: right;
    font-weight: bold;
    margin-top: 15px;
}
</style>

<section class="order-detail-section">
    <div class="order-card">
        <h2>Order #<?= $order['id'] ?> Details</h2>

        <table class="order-table">
            <tr>
                <th>Image</th>
                <th>Item</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Subtotal</th>
            </tr>
            <?php while($item = $items_result->fetch_assoc()): ?>
                <tr>
                    <td><img src="<?= htmlspecialchars($item['image'] ?? '') ?>" alt="<?= htmlspecialchars($item['product_name']) ?>"></td>
                    <td><?= htmlspecialchars($item['product_name']) ?></td>
                    <td>₱<?= number_format($item['price'], 2) ?></td>
                    <td><?= $item['quantity'] ?></td>
                    <td>₱<?= number_format($item['subtotal'], 2) ?></td>
                </tr>
            <?php endwhile; ?>
        </table>

        <div class="order-summary">
            Total: ₱<?= number_format($order['total'], 2) ?><br>
            Status: <?= htmlspecialchars($order['status'] ?? 'Pending') ?><br>
            Ordered on: <?= $order['created_at'] ?>
        </div>

        <div style="text-align:center; margin-top:20px;">
            <a href="user_profile.php" class="back-btn">Back to Profile</a>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>
