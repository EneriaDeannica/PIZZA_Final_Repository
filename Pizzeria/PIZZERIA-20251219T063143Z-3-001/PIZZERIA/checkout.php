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
$cart = $_SESSION['cart'] ?? [];
$total = 0;
$orderSuccess = false;
$orderMessage = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($cart)) {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $address = $_POST['address'] ?? '';

    if ($name && $email && $phone && $address) {
        // Calculate total
        foreach ($cart as $item) {
            $qty = $item['qty'] ?? 1;
            $total += $item['price'] * $qty;
        }

        // Insert order with user_id
        $stmt = $conn->prepare("INSERT INTO orders (user_id, customer_name, email, phone, address, total) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssd", $user_id, $name, $email, $phone, $address, $total);
        $stmt->execute();
        $order_id = $stmt->insert_id;

        // Insert order items
        $item_stmt = $conn->prepare("INSERT INTO order_items (order_id, product_name, price, quantity, subtotal) VALUES (?, ?, ?, ?, ?)");
        foreach ($cart as $item) {
            $qty = $item['qty'] ?? 1;
            $subtotal = $item['price'] * $qty;
            $item_stmt->bind_param("isdid", $order_id, $item['name'], $item['price'], $qty, $subtotal);
            $item_stmt->execute();
        }

        // Clear cart
        unset($_SESSION['cart']);
        $cart = [];
        $orderSuccess = true;
        $orderMessage = "Thank you $name! Your order has been placed successfully. Total: ₱" . number_format($total, 2);
    } else {
        $orderMessage = "Please fill in all fields.";
    }
}
?>

<!-- ====== Styles ====== -->
<style>
.checkout-section {
    padding: 40px 20px;
    display: flex;
    justify-content: center;
}
.checkout-card {
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    padding: 30px 20px;
    max-width: 600px;
    width: 100%;
}
.checkout-title { font-size: 30px; color: #7a1f12; margin-bottom: 25px; text-align: center; }
.checkout-table { width: 100%; border-collapse: collapse; margin-bottom: 25px; }
.checkout-table th, .checkout-table td { padding: 10px; border-bottom: 1px solid #ddd; text-align: center; font-size: 14px; }
.checkout-table img { width: 60px; border-radius: 8px; }
.checkout-total { font-size: 20px; font-weight: bold; text-align: right; margin-bottom: 25px; }
.checkout-form label { display: block; margin: 5px 0 5px; font-weight: bold; font-size: 14px; }
.checkout-form input, .checkout-form textarea { width: 95%; padding: 5px; border-radius: 6px; border: 1px solid #ddd; font-size: 14px; margin-bottom: 10px; }
.place-order-btn { display: inline-block; margin-top: 15px; background: #7a1f12; color: #fff; padding: 12px 24px; border-radius: 25px; border: none; cursor: pointer; font-size: 14px; transition: 0.3s; }
.place-order-btn:hover { background: #a93226; }
.order-success { text-align: center; font-size: 16px; color: #fff; background: #4caf50; padding: 15px 20px; border-radius: 10px; margin-bottom: 20px; }
</style>

<section class="checkout-section">
    <div class="checkout-card">
        <h1 class="checkout-title">Checkout</h1>

        <?php if ($orderSuccess): ?>
            <div class="order-success"><?= $orderMessage ?></div>
            <a href="home.php" class="place-order-btn">Back to Home</a>
        <?php else: ?>
            <?php if (!empty($cart)): ?>
                <table class="checkout-table">
                    <tr>
                        <th>Image</th>
                        <th>Item</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                    </tr>
                    <?php foreach ($cart as $item):
                        $qty = $item['qty'] ?? 1;
                        $subtotal = $item['price'] * $qty;
                        $total += $subtotal;
                    ?>
                    <tr>
                        <td><img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>"></td>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td>₱<?= number_format($item['price'], 2) ?></td>
                        <td><?= $qty ?></td>
                        <td>₱<?= number_format($subtotal, 2) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>

                <div class="checkout-total">
                    Total: ₱<?= number_format($total, 2) ?>
                </div>

                <form action="" method="POST" class="checkout-form">
                    <label for="name">Full Name</label>
                    <input type="text" name="name" id="name" required>

                    <label for="email">Email Address</label>
                    <input type="email" name="email" id="email" required>

                    <label for="phone">Phone Number</label>
                    <input type="text" name="phone" id="phone" required>

                    <label for="address">Delivery Address</label>
                    <textarea name="address" id="address" rows="3" required></textarea>

                    <button type="submit" class="place-order-btn">Place Order</button>
                </form>
            <?php else: ?>
                <p>Your cart is empty. Add items to checkout.</p>
            <?php endif; ?>

            <?php if($orderMessage && !$orderSuccess): ?>
                <div class="order-success" style="background:#f44336;"><?= $orderMessage ?></div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>

<?php include 'footer.php'; ?>
