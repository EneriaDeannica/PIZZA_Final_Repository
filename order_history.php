<?php
session_start();

include "pizzeria_db.php";
include "header.php";

if (!isset($_SESSION['user_id']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

/* ================= FETCH ORDER HISTORY ================= */
$orders = [];

// Fetch all orders
$stmt = mysqli_prepare($conn, "SELECT order_id, total, status, created_at FROM orders WHERE user_id=? ORDER BY created_at DESC");
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$order_result = mysqli_stmt_get_result($stmt);

$order_ids = [];
while ($row = mysqli_fetch_assoc($order_result)) {
    $orders[$row['order_id']] = [
        'info' => [
            'total' => $row['total'],
            'status'=> $row['status'],
            'date'  => $row['created_at']
        ],
        'items' => []
    ];
    $order_ids[] = $row['order_id'];
}
mysqli_stmt_close($stmt);

// Fetch all items for the orders
if (!empty($order_ids)) {
    $placeholders = implode(',', array_fill(0, count($order_ids), '?'));
    $types = str_repeat('i', count($order_ids));
    $sql = "SELECT order_id, product_name, quantity, price FROM order_items WHERE order_id IN ($placeholders)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, $types, ...$order_ids);
    mysqli_stmt_execute($stmt);
    $items_result = mysqli_stmt_get_result($stmt);

    while ($item = mysqli_fetch_assoc($items_result)) {
        $orders[$item['order_id']]['items'][] = [
            'name' => $item['product_name'],
            'qty'  => $item['quantity'],
            'price'=> $item['price']
        ];
    }
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Order History</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
* { box-sizing: border-box; font-family: Arial, sans-serif; }

.container { 
    max-width:1000px; 
    margin: 80px auto; 
    background:#e5e5e5; 
    border-radius:20px; 
    padding:30px; 
}

h2 { margin-bottom:20px; }

.order-card {
    background:#fff; 
    border-radius:15px; 
    padding:25px; 
    max-height: 1000px; 
    min-height: 600px;  
    overflow-y:auto; 
}

.order-table { 
    width:100%; 
    border-collapse: collapse; 
    margin-bottom:30px; 
}

.order-table th, .order-table td { 
    padding:12px; 
    border-bottom:1px solid #ddd; 
    text-align:left; 
}

.order-table th { background:#c14a1b; color:white; }

.order-actions {
    margin-top:15px;
    margin-bottom:40px; 
}

.order-actions button { 
    margin-right:12px; 
    padding:12px 18px; 
    border:none; 
    border-radius:5px; 
    cursor:pointer; 
}

.order-actions button.cancel { background:#e74c3c; color:white; }
.order-actions button.delivered { background:#2ecc71; color:white; }
.order-actions button:disabled { opacity:0.6; cursor:not-allowed; }

.order-status { font-weight:bold; padding:6px 12px; border-radius:5px; color:white; }
.status-cancelled { background:#e74c3c; }
.status-onway { background:#f1c40f; }
.status-delivered { background:#2ecc71; }


.order-status {
    background: none !important;
    padding: 0 !important;
    border-radius: 0 !important;
    box-shadow: none !important;
}

/* Optional: color only (NO background) */
.status-pending   { color: #c14a1b; }
.status-onway     { color: #e67e22; }
.status-delivered { color: #2ecc71; }
.status-cancelled { color: #e74c3c; }

</style>
<script>
function orderAction(orderId, actionBtn) {
    const action = actionBtn.value;
    fetch('cus_order_action.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `order_id=${orderId}&action=${action}`
    })
    .then(res => res.text())
    .then(res => {
        if(res === 'success'){
            const statusElem = document.getElementById('status-' + orderId);
            if(action === 'cancel') {
                statusElem.textContent = 'Cancelled';
                statusElem.className = 'order-status status-cancelled';
            }
            if(action === 'delivered') {
                statusElem.textContent = 'Delivered';
                statusElem.className = 'order-status status-delivered';
            }
            if(action === 'on way') { // admin marked as on way
                statusElem.textContent = 'Out for delivery';
                statusElem.className = 'order-status status-onway';
            }
            // Disable buttons after action
            actionBtn.closest('.order-actions').querySelectorAll('button').forEach(b=>b.disabled=true);
        } else {
            alert('Action failed.');
        }
    });
}
</script>
</head>
<body>

<div class="container">
    <h2>Order History</h2>

    <div class="order-card">
        <?php if(empty($orders)): ?>
            <p>No orders found.</p>
        <?php else: ?>
            <?php foreach($orders as $id => $order): ?>
                <?php
                    $status = $order['info']['status'];
                    $statusText = $status === 'pending' ? 'Pending' :
                                  ($status === 'on way' ? 'Out for delivery' :
                                  ($status === 'delivered' ? 'Delivered' :
                                  ($status === 'cancel' ? 'Cancelled' : ucfirst($status))));

                    $statusClass = $status === 'pending' ? 'status-onway' :
                                   ($status === 'on way' ? 'status-onway' :
                                   ($status === 'delivered' ? 'status-delivered' :
                                   ($status === 'cancel' ? 'status-cancelled' : '')));
                ?>
                <p>
                    <strong>Order #<?= $id ?></strong> - 
                    Status: <span id="status-<?= $id ?>" class="order-status <?= $statusClass ?>"><?= $statusText ?></span> - 
                    Date: <?= date("M d, Y", strtotime($order['info']['date'])) ?> - 
                    Total: ₱<?= number_format($order['info']['total'],2) ?>
                </p>
                <table class="order-table">
                    <tr><th>Item</th><th>Qty</th><th>Price</th></tr>
                    <?php foreach($order['items'] as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['name']) ?></td>
                            <td>x<?= $item['qty'] ?></td>
                            <td>₱<?= number_format($item['price'],2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <div class="order-actions" id="actions-<?= $id ?>">
                    <?php if ($order['info']['status'] === 'pending'): ?>
                        <button type="button"
                                value="cancel"
                                class="cancel"
                                onclick="orderAction(<?= $id ?>, this)">
                            Cancel
                        </button>
                    <?php endif; ?>

                    <?php if ($order['info']['status'] === 'on way'): ?>
                        <button type="button"
                                value="delivered"
                                class="delivered"
                                onclick="orderAction(<?= $id ?>, this)">
                            Delivered
                        </button>
                    <?php endif; ?>
                </div>

                <hr>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

</body>
</html>

<?php include 'footer.php'; ?>
