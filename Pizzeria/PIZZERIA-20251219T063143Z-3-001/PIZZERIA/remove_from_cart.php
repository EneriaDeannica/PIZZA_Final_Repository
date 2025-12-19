<?php
session_start();

// Get id from URL
$id = $_GET['id'] ?? '';

if ($id && isset($_SESSION['cart'][$id])) {
    unset($_SESSION['cart'][$id]); // Remove the item
}

// Redirect back to cart page
header('Location: cart.php');
exit();
?>
