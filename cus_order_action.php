<?php
session_start();
include "pizzeria_db.php";
include "conn.php";

/* Must be logged in (customer) */
if (!isset($_SESSION['user_id']) || $_SESSION['logged_in'] !== true) {
    echo "error";
    exit;
}

$user_id  = $_SESSION['user_id'];
$order_id = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;
$action   = $_POST['action'] ?? '';

if (!$order_id || !$action) {
    echo "error";
    exit;
}

/* Get current order status and ownership */
$stmt = $conn->prepare("SELECT status FROM orders WHERE order_id=? AND user_id=?");
$stmt->bind_param("ii", $order_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "error";
    exit;
}

$order = $result->fetch_assoc();
$current_status = $order['status'];
$stmt->close();

/* Determine allowed transitions */
if ($action === 'cancel' && $current_status === 'pending') {
    $new_status = 'cancelled';
} elseif ($action === 'delivered' && $current_status === 'on way') {
    $new_status = 'delivered';
} else {
    echo "error";
    exit;
}

/* Update order */
$stmt = $conn->prepare(
    "UPDATE orders SET status=? WHERE order_id=? AND user_id=?"
);
$stmt->bind_param("sii", $new_status, $order_id, $user_id);

if ($stmt->execute()) {
    echo "success";   // 🔥 JS NEEDS THIS EXACT WORD
} else {
    echo "error";
}

$stmt->close();
$conn->close();
?>
