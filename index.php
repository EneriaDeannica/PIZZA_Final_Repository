<?php
// No session logic needed because we always go to login
if (isset($_GET['order'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pizzeria Landing Page</title>
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }

  body {
    background: url('lp.png') no-repeat center center/cover;
    height: 100vh;
    width: 100%;
    display: flex;
    justify-content: space-between;
  }

  nav {
    position: absolute;
    top: 20px;
    right: 30px;
  }

  nav ul {
    list-style: none;
    display: flex;
    gap: 15px;
  }

  nav ul li a {
    text-decoration: none;
    padding: 8px 18px;
    background: rgba(205, 92, 92, 0.9);
    color: white;
    font-weight: bold;
    border-radius: 5px;
    transition: 0.3s;
    box-shadow: #000 4px 4px 0;
  }

  nav ul li a:hover {
    background: #a52a2a;
  }

  .left-section {
    width: 35%;
    padding: 60px 40px;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: flex-start;
  }

  .logo img {
    position: absolute;
    left: 20px;
    top: 20px;
    width: 200px;
    height: auto;
  }

  .slogan {
    font-family: 'Pacifico', cursive;
    font-size: 70px;
    line-height: 1.6;
    margin: 100px 20px 20px 20px;
  }

  .order-btn {
    background: #e74c3c;
    color: white;
    padding: 14px 28px;
    font-size: 18px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    box-shadow: 4px 4px 0 #000;
    transition: 0.3s;
  }

  .order-btn:hover {
    background: #a52a2a;
  }
</style>
</head>
<body>

<!-- Navigation -->
<nav>
  <ul>
    <li><a href="login.php">Log In</a></li>
    <li><a href="signup.php">Sign Up</a></li>
  </ul>
</nav>

<!-- Left Content -->
<div class="left-section">
  <div class="logo">
    <img src="Pizzeria logo.png" alt="Pizzeria Logo">
  </div>
  <p class="slogan">“A Slice of HAPPINESS <br>for Every SMILE”</p>

  <!-- Order Now Button -->
  <form method="GET">
    <button class="order-btn" type="submit" name="order">Order Now</button>
  </form>
</div>

</body>
</html>
