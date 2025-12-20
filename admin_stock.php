<?php
session_start();
include "pizzeria_db.php";
include "conn.php";

// Protect Admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo 'error';
    exit;
}

// Get POST data
$id = $_POST['id'] ?? 0;
$action = $_POST['action'] ?? '';

if(!$id || !in_array($action, ['add','minus'])) {
    echo 'error';
    exit;
}

// Fetch current stock
$stmt = $conn->prepare("SELECT stock FROM menu WHERE menu_id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if($result->num_rows === 0){
    echo 'error';
    $stmt->close();
    exit;
}
$row = $result->fetch_assoc();
$currentStock = (int)$row['stock'];
$stmt->close();

// Calculate new stock
$newStock = $action === 'add' ? $currentStock + 1 : max(0, $currentStock - 1);

// Update stock
$stmt = $conn->prepare("UPDATE menu SET stock=? WHERE menu_id=?");
$stmt->bind_param("ii", $newStock, $id);

if($stmt->execute()){
    echo 'success';
} else {
    echo 'error';
}

$stmt->close();
$conn->close();
?>
