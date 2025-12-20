<?php
include "pizzeria_db.php";
$email = 'newtestemail@example.com';
$stmt = mysqli_prepare($conn, "SELECT user_id FROM users WHERE email=?");
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);
echo mysqli_stmt_num_rows($stmt);
