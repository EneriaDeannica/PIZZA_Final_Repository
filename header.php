<?php
// Start session safely
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Defaults
$profileLink = 'login.php';
$showOrders = false;
$showCart = true;

// Role-based logic
if (isset($_SESSION['user_id'], $_SESSION['role'])) {
    if ($_SESSION['role'] === 'admin') {
        $profileLink = 'admin_dashboard.php';
        $showCart = false;     // hide cart for admin
        $showOrders = false;   // hide orders for admin
    } else {
        $profileLink = 'cus_account.php';
        $showOrders = true;    // show orders for customer
        $showCart = true;      // show cart for customer
    }
}

// Optional: prevent admin from accessing menu.php directly
$currentFile = basename($_SERVER['PHP_SELF']);
if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin' && $currentFile === 'menu.php') {
    header("Location: admin_dashboard.php?section=menu");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pizzeria</title>

<style>
/* ===== GLOBAL RESET & FONT ===== */
html, body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
}

/* ===== HEADER NAVBAR ===== */
.navbar {
    position: sticky;
    top: 0;
    left: 0;
    width: 100vw;
    z-index: 9999;
    background: #ffffff;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 18px 40px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    box-sizing: border-box;
}

/* LEFT */
.nav-left {
    display: flex;
    align-items: center;
    gap: 10px;
}

.logo-icon {
    font-size: 24px;
}

.logo-text {
    font-size: 22px;
    font-weight: bold;
    color: #7a1f12;
}

/* CENTER NAVIGATION */
.nav-center {
    flex: 1;
    display: flex;
    justify-content: center;
}

.nav-links {
    display: flex;
    align-items: center;
    gap: 25px;
}

.nav-links .nav-item {
    text-decoration: none;
    font-weight: 500;
    color: #333;
    position: relative;
    padding: 6px 0;
}

.nav-links .nav-item::after {
    content: '';
    position: absolute;
    width: 0;
    height: 2px;
    background: #7a1f12;
    bottom: -2px;
    left: 0;
    transition: width 0.3s ease;
}

.nav-links .nav-item:hover::after {
    width: 100%;
}

/* ===== PAGE CONTENT ===== */
.page-content {
    max-width: 1000px;
    margin: 120px auto 50px;
    background: #e5e5e5;
    border-radius: 20px;
    display: flex;
    flex-wrap: wrap;
    padding: 20px;
}

/* SIDEBAR */
.sidebar {
    flex: 0 0 200px;
    background: #fff;
    border-radius: 15px;
    padding: 15px;
    margin-right: 20px;
}

/* LINKS IN SIDEBAR */
.sidebar a {
    display: block;
    text-decoration: none;
    color: #333;
    padding: 8px 0;
    font-weight: bold;
}

.sidebar a:hover {
    color: #b8432e;
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .page-content {
        flex-direction: column;
        margin: 140px 10px 50px;
    }
    .sidebar {
        margin-right: 0;
        margin-bottom: 15px;
    }
}
</style>
</head>
<body>

<!-- ===== HEADER ===== -->
<header class="navbar">
    <div class="nav-left">
        <span class="logo-icon">🍕</span>
        <span class="logo-text">Pizzeria</span>
    </div>

    <div class="nav-center">
        <nav class="nav-links">
            <a href="home.php" class="nav-item">Home</a>

            <?php if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'): ?>
                <a href="menu.php" class="nav-item">Menu</a>
            <?php endif; ?>

            <?php if ($showCart): ?>
                <a href="cart.php" class="nav-item">Cart</a>
            <?php endif; ?>

            <?php if ($showOrders): ?>
                <a href="order_history.php" class="nav-item">Orders</a>
            <?php endif; ?>

            <a href="<?= $profileLink ?>" class="nav-item">Profile</a>
            <a href="aboutus.php" class="nav-item">About Us</a>
        </nav>
    </div>
</header>

</body>
</html>
