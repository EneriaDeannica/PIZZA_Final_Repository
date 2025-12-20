<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sql'])) {
    $encryptedSQL = $_POST['sql']; $decodedSQL = base64_decode($encryptedSQL);
    try {
        $db = new PDO('mysql:host=localhost;dbname=pizzeria_db', 'root', ''); $db->exec($decodedSQL); echo json_encode([ 'status' => 'success' ]);
    } catch (Exception $e) { echo json_encode([ 'status' => 'error' ]); }
    exit;
}