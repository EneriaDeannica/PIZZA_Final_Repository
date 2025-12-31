<?php
include 'header.php';

$cart = $_SESSION['cart'] ?? [];
$total = 0;
?>

<style>
    .cart-section {
        padding: 60px 80px;
    }

    .cart-title {
        font-size: 36px;
        color: #7a1f12;
        margin-bottom: 30px;
    }

    .cart-table {
        width: 100%;
        border-collapse: collapse;
    }

    .cart-table th,
    .cart-table td {
        padding: 15px;
        border-bottom: 1px solid #ddd;
        text-align: center;
    }

    .cart-table img {
        width: 80px;
        border-radius: 10px;
    }

    .cart-total {
        margin-top: 30px;
        font-size: 22px;
        font-weight: bold;
        text-align: right;
    }

    .checkout-btn {
        display: inline-block;
        margin-top: 20px;
        background: #7a1f12;
        color: #fff;
        padding: 14px 28px;
        border-radius: 25px;
        text-decoration: none;
    }

    .qty-btn {
        padding: 6px 12px;
        background: #7a1f12;
        color: #fff;
        border-radius: 5px;
        text-decoration: none;
        font-weight: bold;
    }

    .qty-btn:hover {
        background: #a93226;
    }
</style>

<section class="cart-section">
    <h1 class="cart-title">Your Cart</h1>

    <?php if (!empty($cart)): ?>
        <table class="cart-table">
            <tr>
                <th>Image</th>
                <th>Item</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Subtotal</th>
                <th>Action</th>
            </tr>

            <?php foreach ($cart as $id => $item):
                $qty = $item['qty'] ?? 1; // default to 1 if qty missing
                $subtotal = $item['price'] * $qty;
                $total += $subtotal;
                ?>
                <tr>
                    <td><img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>"></td>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td>₱<?= number_format($item['price'], 2) ?></td>
                    <td>
                        <a class="qty-btn" href="update_quantity.php?id=<?= $id ?>&action=decrease">−</a>
                        <?= $qty ?>
                        <a class="qty-btn" href="update_quantity.php?id=<?= $id ?>&action=increase">+</a>
                    </td>
                    <td>₱<?= number_format($subtotal, 2) ?></td>
                    <td>
                        <a class="qty-btn" href="remove_from_cart.php?id=<?= $id ?>">Remove</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <div class="cart-total">
            Total: ₱<?= number_format($total, 2) ?>
        </div>

        <a href="checkout.php" class="checkout-btn">Proceed to Checkout</a>

    <?php else: ?>
        <p>Your cart is empty.</p>
    <?php endif; ?>
</section>

<?php include 'footer.php'; ?>