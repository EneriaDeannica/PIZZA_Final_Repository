<?php
session_start();
include "pizzeria_db.php";

// Only allow admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo 'error';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = intval($_POST['product_id']);
    $action    = $_POST['action'];

    if ($action === 'increase') {
        $stmt = $conn->prepare("UPDATE menu SET stock = stock + 1 WHERE id=?");
        $stmt->bind_param("i", $productId);
    } elseif ($action === 'decrease') {
        $stmt = $conn->prepare("UPDATE menu SET stock = GREATEST(stock - 1,0) WHERE id=?");
        $stmt->bind_param("i", $productId);
    } elseif ($action === 'remove') {
        $stmt = $conn->prepare("DELETE FROM menu WHERE id=?");
        $stmt->bind_param("i", $productId);
    } else {
        echo 'error';
        exit;
    }

    if ($stmt->execute()) echo 'success';
    else echo 'error';
    $stmt->close();
} else {
    echo 'error';
}
?>
