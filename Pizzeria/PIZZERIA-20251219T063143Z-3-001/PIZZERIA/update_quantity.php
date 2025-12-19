<?php
session_start();

// Make sure cart exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Get id and action from URL
$id = $_GET['id'] ?? '';
$action = $_GET['action'] ?? '';

if ($id && isset($_SESSION['cart'][$id])) {
    switch ($action) {
        case 'increase':
            $_SESSION['cart'][$id]['qty'] += 1;
            break;

        case 'decrease':
            $_SESSION['cart'][$id]['qty'] -= 1;
            // Remove item if quantity drops below 1
            if ($_SESSION['cart'][$id]['qty'] < 1) {
                unset($_SESSION['cart'][$id]);
            }
            break;
    }
}

// Redirect back to cart page
header('Location: cart.php');
exit();
?>
