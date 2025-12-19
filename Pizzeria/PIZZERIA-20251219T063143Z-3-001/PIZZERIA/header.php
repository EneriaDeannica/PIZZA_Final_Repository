<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pizzeria</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<style>
    /* ===== HEADER ===== */
.navbar {
    position: sticky;
    top: 0;
    z-index: 1000;
    background: #ffffff;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 18px 80px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
}

.nav-left {
    display: flex;
    align-items: center;
    gap: 10px;
}

.logo-text {
    font-size: 22px;
    font-weight: bold;
    color: #7a1f12;
}

.nav-links .nav-item {
    margin: 0 18px;
    text-decoration: none;
    font-weight: 500;
    color: #333;
    position: relative;
}

.nav-links .nav-item::after {
    content: '';
    position: absolute;
    width: 0;
    height: 2px;
    background: #7a1f12;
    bottom: -6px;
    left: 0;
    transition: 0.3s;
}

.nav-links .nav-item:hover::after {
    width: 100%;
}

.nav-right {
    display: flex;
    gap: 15px;
}

.icon-btn {
    font-size: 18px;
    background: #f6f1ed;
    padding: 10px 14px;
    border-radius: 50%;
    text-decoration: none;
    transition: 0.3s;
}

.icon-btn:hover {
    background: #7a1f12;
    color: #fff;
}

</style>

<header class="navbar">
    <div class="nav-left">
        <span class="logo-icon">🍕</span>
        <span class="logo-text">Pizzeria</span>
    </div>

    <nav class="nav-links">
        <a href="home.php" class="nav-item">Home</a>
        <a href="menu.php" class="nav-item">Menu</a>
        <a href="aboutus.php" class="nav-item">About Us</a>
    </nav>

    <div class="nav-right">
        <a href="cart.php" class="icon-btn" title="Cart">🛒</a>
        <a href="user_profile.php" class="icon-btn" title="Profile">👤</a>
    </div>
</header>
