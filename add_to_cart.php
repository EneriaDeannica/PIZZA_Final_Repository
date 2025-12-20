<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$name  = $_POST['name'] ?? '';
$price = isset($_POST['price']) ? floatval($_POST['price']) : 0;
$image = $_POST['image'] ?? '';

$response = [];

if ($name) {
    $id = strtolower(str_replace(' ', '', $name));
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['qty'] += 1;
    } else {
        $_SESSION['cart'][$id] = [
            'name' => $name,
            'price' => $price,
            'image' => $image,
            'qty' => 1
        ];
    }
    $response['status'] = 'success';
    $response['message'] = "$name added to cart!";
} else {
    $response['status'] = 'error';
    $response['message'] = "No product data received.";
}

header('Content-Type: application/json');
echo json_encode($response);
exit();
