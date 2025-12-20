<?php
session_start();
include "pizzeria_db.php";

if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_POST['order_id'])) {
    header("Location: order_history.php");
    exit;
}

$order_id = (int)$_POST['order_id'];
$user_id = $_SESSION['user_id'];

$stmt = mysqli_prepare(
    $conn,
    "UPDATE orders 
     SET status = 'delivered' 
     WHERE id = ? AND user_id = ? AND status = 'out_for_delivery'"
);

mysqli_stmt_bind_param($stmt, "ii", $order_id, $user_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

header("Location: order_history.php");
exit;
