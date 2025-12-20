<?php
session_start();
include "pizzeria_db.php";
include "conn.php";

/* Only allow admin */
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo "unauthorized";
    exit;
}

if(!isset($_POST['order_id'], $_POST['action'])){
    echo "invalid";
    exit;
}

$order_id = intval($_POST['order_id']);
$action = $_POST['action'];

/* Update order status */
$stmt = $conn->prepare("UPDATE orders SET status=? WHERE order_id=?");
$stmt->bind_param("si", $action, $order_id);
if($stmt->execute()){

    /* If order is confirmed/on way, reduce stock */
    if($action === 'on way' || $action === 'delivered'){
        $items = $conn->query("SELECT product_id, quantity FROM order_items WHERE order_id=$order_id");
        while($row = $items->fetch_assoc()){
            $conn->query("UPDATE menu SET stock = GREATEST(stock - {$row['quantity']}, 0) WHERE menu_id = {$row['product_id']}");
        }
    }

    echo "success";
}else{
    echo "fail";
}
$stmt->close();
?>
