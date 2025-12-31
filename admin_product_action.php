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
    $action = $_POST['action'];

    if ($action === 'delete') {
        $stmt = $conn->prepare("DELETE FROM menu WHERE product_id=?");
        $stmt->bind_param("i", $productId);
    } else {
        echo 'error';
        header("Location: menu.php");
        exit;
    }

    if ($stmt->execute())
        echo 'success';
    else
        echo 'error';
    $stmt->close();
} else {
    echo 'error';
}
?>