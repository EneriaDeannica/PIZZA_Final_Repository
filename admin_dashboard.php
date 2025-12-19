<?php
session_start();
include "pizzeria_db.php";
include 'header.php';
// Check if admin

// Fetch orders for dashboard
$orders = $conn->query("SELECT o.id, u.username, o.total, o.created_at 
                        FROM orders o 
                        JOIN users u ON o.user_id = u.id 
                        ORDER BY o.created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard</title>
<style>
body { font-family: Arial; background: #f9f9f9; margin:0; padding:0;}
header { background:#7a1f12; color:#fff; padding:15px; text-align:center;}
.dashboard { padding:20px; max-width:1000px; margin: auto;}
h2 { color:#7a1f12; }
table { width:100%; border-collapse: collapse; margin-top:20px;}
th, td { padding:12px; border:1px solid #ddd; text-align:center;}
th { background:#f2f2f2; }
.logout-btn { background:#b8432e; color:#fff; padding:8px 16px; border:none; border-radius:5px; cursor:pointer; text-decoration:none;}
.logout-btn:hover { background:#a03827; }
</style>
</head>
<body>
<header>
    <h1>Admin Dashboard</h1>
    <a href="logout.php" class="logout-btn">Logout</a>
</header>

<div class="dashboard">
    <h2>Recent Orders</h2>
    <?php if ($orders && $orders->num_rows > 0): ?>
        <table>
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Total</th>
                <th>Ordered At</th>
            </tr>
            <?php while($row = $orders->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['username']) ?></td>
                    <td>₱<?= number_format($row['total'],2) ?></td>
                    <td><?= $row['created_at'] ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No orders found.</p>
    <?php endif; ?>
</div>
</body>
</html>
