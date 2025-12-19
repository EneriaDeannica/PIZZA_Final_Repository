<?php
$host = "localhost";   // usually localhost
$user = "root";        // your MySQL username
$pass = "";            // your MySQL password (usually empty in XAMPP)
$db   = "pizzeria_db"; // your database name

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
