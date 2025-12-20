<?php
include "pizzeria_db.php";

if(isset($_POST['email'])) {
    $email = trim($_POST['email']);

    $stmt = mysqli_prepare($conn, "SELECT user_id FROM users WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if(mysqli_stmt_num_rows($stmt) > 0) {
        echo 'exists';
    } else {
        echo 'available';
    }

    mysqli_stmt_close($stmt);
}
// No closing PHP tag and no whitespace before <?php
