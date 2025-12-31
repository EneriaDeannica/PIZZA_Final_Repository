<?php
session_start();
include "pizzeria_db.php";
include "header.php";

/* Protect Admin */
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

/* Allowed sections */
$allowed = ['dashboard', 'orders', 'menu', 'add_product'];
$section = $_GET['section'] ?? 'dashboard';
if (!in_array($section, $allowed)) {
    $section = 'dashboard';
}

/* FUNCTIONS */
function getTotal($conn, $table)
{
    $res = $conn->query("SELECT COUNT(*) total FROM $table");
    return $res->fetch_assoc()['total'];
}

function getCount($conn, $status)
{
    $stmt = $conn->prepare("SELECT COUNT(*) FROM orders WHERE status=?");
    $stmt->bind_param("s", $status);
    $stmt->execute();
    $stmt->bind_result($status);
    $stmt->fetch();
    $stmt->close();
    return $status;
}

function fetchOrders($conn)
{
    $res = $conn->query("
        SELECT o.order_id, u.username, o.total, o.status
        FROM orders o
        JOIN users u ON o.user_id = u.user_id
        ORDER BY o.order_id DESC
    ");
    return $res->fetch_all(MYSQLI_ASSOC);
}

function fetchOrderItems($conn, $orderId)
{
    $stmt = $conn->prepare("
        SELECT product_name, quantity
        FROM order_items
        WHERE order_id=?
    ");
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $items;
}

function fetchMenuItems($conn)
{
    $res = $conn->query("
        SELECT m.*, c.name AS category
        FROM menu m
        JOIN categories c ON m.category_id = c.id
        WHERE m.status = 1
        ORDER BY m.menu_id DESC
    ");
    return $res->fetch_all(MYSQLI_ASSOC);
}

function fetchCategories($conn)
{
    $res = $conn->query("SELECT id, name FROM categories ORDER BY name ASC");
    return $res->fetch_all(MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* ===== GENERAL ===== */
        * {
            box-sizing: border-box;
            font-family: Arial;
            margin: 0;
            padding: 0
        }

        body {
            background: #f4f4f9;
            color: #333
        }

        .wrapper {
            max-width: 1300px;
            margin: 30px auto;
            display: flex;
            gap: 20px
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            background: #8b2e20;
            color: white;
            border-radius: 20px;
            padding: 30px 20px;
            display: flex;
            flex-direction: column;
            align-items: center
        }

        .sidebar img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 4px solid #fff;
            margin-bottom: 15px
        }

        .sidebar h2 {
            margin-bottom: 30px
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            margin: 10px 0;
            width: 100%;
            text-align: center;
            padding: 10px;
            border-radius: 8px
        }

        .sidebar a:hover {
            background: rgba(255, 255, 255, .2)
        }

        .logout {
            margin-top: auto;
            background: #c14a1b
        }

        /* Content */
        .content {
            flex: 1;
            padding: 30px
        }

        h1 {
            color: #7b1f1f;
            margin-bottom: 20px
        }

        /* Cards */
        .cards {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            margin-bottom: 40px
        }

        .card {
            flex: 1 1 200px;
            background: #d49677;
            border-radius: 20px;
            padding: 25px;
            color: white;
            text-align: center
        }

        .card p {
            font-size: 36px;
            font-weight: bold
        }

        /* Table */
        .table-card {
            background: #fff;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, .1)
        }

        table {
            width: 100%;
            border-collapse: collapse
        }

        th,
        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: center;
            vertical-align: middle
        }

        th {
            background: #c14a1b;
            color: white
        }

        ul {
            padding-left: 15px
        }

        /* Buttons */
        .order-actions button,
        .stock-btn,
        .admin-menu-btn {
            padding: 6px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold
        }

        .cancel {
            background: #e74c3c;
            color: white
        }

        .onway {
            background: #f1c40f;
            color: white
        }

        .stock-btn {
            background: #c14a1b;
            color: white;
            margin: 0 3px
        }

        .admin-menu-btn {
            background: #3498db;
            color: white;
            margin: 0 3px
        }

        .admin-menu-btn.delete {
            background: #e74c3c;
            color: white;
            margin: 0 3px
        }

        /* Admin Menu Grid */
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .menu-card {
            position: relative;
            background: #fff;
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, .08);
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 300px;
        }

        .menu-card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 15px;
            margin-bottom: 10px;
        }

        .menu-card h3 {
            color: #7b1f1f;
            margin-bottom: 5px;
        }

        .menu-card p {
            font-size: 14px;
            color: #555;
            text-align: center;
            margin-bottom: 10px;
        }

        .admin-actions {
            position: absolute;
            bottom: 15px;
            display: flex;
            gap: 5px;
            align-items: center;
        }

        /* Add Product Form */
        .add-product-container {
            max-width: 600px;
            margin: 50px auto;
            background: #fff;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, .08);
        }

        .add-product-container h2 {
            color: #7b1f1f;
            margin-bottom: 20px;
            text-align: center;
        }

        .add-product-container form input,
        .add-product-container form textarea,
        .add-product-container form select {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        .add-product-container form button {
            background: #c14a1b;
            color: #fff;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
        }

        .add-product-container .message {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }

        @media(max-width:900px) {
            .wrapper {
                flex-direction: column
            }

            .sidebar {
                width: 100%;
                flex-direction: row;
                justify-content: space-around
            }

            .sidebar h2,
            .sidebar img {
                display: none
            }
        }
    </style>

    <script>
        function orderAction(orderId, btn) {
            fetch("admin_order_action.php", {
                method: "POST",
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `order_id=${orderId}&action=${btn.value}`
            })
                .then(r => r.text())
                .then(r => {
                    if (r === 'success') {
                        document.getElementById('status-' + orderId).innerText =
                            btn.value === 'cancel' ? 'Cancelled' : 'On Way';
                        btn.disabled = true;
                        btn.parentElement.querySelectorAll('button').forEach(b => b.disabled = true);
                    } else alert("Failed");
                });
        }

        function updateMenuStock(id, action) {
            fetch("admin_stock.php", { // renamed the original: admin_stock_action.php
                method: "POST",
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `id=${id}&action=${action}`
            })
                .then(r => r.text())
                .then(r => {
                    if (r === 'success') {
                        let el = document.getElementById('menu-stock-' + id);
                        let val = parseInt(el.innerText);
                        el.innerText = action === 'add' ? val + 1 : Math.max(0, val - 1);
                    } else alert("Failed");
                });
        }
    </script>

</head>

<body>
    <div class="wrapper">

        <div class="sidebar">
            <img src="https://via.placeholder.com/100">
            <h2>Admin</h2>
            <a href="logout.php" class="logout">Logout</a>
            <a href="?section=dashboard">Dashboard</a>
            <a href="?section=orders">Orders</a>
            <a href="?section=menu">Menu</a>
            <a href="?section=add_product">Add Product</a>

        </div>

        <div class="content">

            <?php if ($section === 'dashboard'): ?>
                <h1>Dashboard</h1>
                <div class="cards">
                    <div class="card">
                        <h4>Products</h4>
                        <p><?= getTotal($conn, 'menu') ?></p>
                    </div>
                    <div class="card">
                        <h4>Users</h4>
                        <p><?= getTotal($conn, 'users') ?></p>
                    </div>
                    <div class="card">
                        <h4>Pending Orders</h4>
                        <p><?= getCount($conn, 'pending') ?></p>
                    </div>
                    <div class="card">
                        <h4>Out for Delivery</h4>
                        <p><?= getCount($conn, 'on way') ?></p>
                    </div>
                    <div class="card">
                        <h4>Delivered Orders</h4>
                        <p><?= getCount($conn, 'delivered') ?></p>
                    </div>
                </div>

            <?php elseif ($section === 'orders'): ?>
                <h1>Orders</h1>
                <div class="table-card">
                    <table>
                        <tr>
                            <th>Order ID</th>
                            <th>User</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Items</th>
                            <th>Action</th>
                        </tr>
                        <?php foreach (fetchOrders($conn) as $o): ?>
                            <tr>
                                <td>#<?= $o['order_id'] ?></td>
                                <td><?= htmlspecialchars($o['username']) ?></td>
                                <td>₱<?= number_format($o['total'], 2) ?></td>
                                <td id="status-<?= $o['order_id'] ?>"><?= ucfirst($o['status']) ?></td>
                                <td>
                                    <ul>
                                        <?php foreach (fetchOrderItems($conn, $o['order_id']) as $i): ?>
                                            <li><?= $i['product_name'] ?> × <?= $i['quantity'] ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </td>
                                <td class="order-actions">
                                    <?php if ($o['status'] === 'pending'): ?>
                                        <button value="cancel" class="cancel"
                                            onclick="orderAction(<?= $o['order_id'] ?>,this)">Cancel</button>
                                        <button value="on way" class="onway" onclick="orderAction(<?= $o['order_id'] ?>,this)">On
                                            Way</button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>

            <?php elseif ($section === 'menu'): ?>
                <h1>Admin Menu</h1>
                <div class="menu-grid">
                    <?php foreach (fetchMenuItems($conn) as $m): ?>
                        <div class="menu-card">
                            <img src="<?= $m['image'] ?>" alt="<?= $m['name'] ?>">
                            <h3><?= htmlspecialchars($m['name']) ?></h3>
                            <p><?= htmlspecialchars($m['description']) ?></p>
                            <div class="admin-actions">
                                <button class="admin-menu-btn"
                                    onclick="updateMenuStock(<?= $m['menu_id'] ?>,'minus')">−</button>
                                <span id="menu-stock-<?= $m['menu_id'] ?>"><?= $m['stock'] ?></span>
                                <button class="admin-menu-btn" onclick="updateMenuStock(<?= $m['menu_id'] ?>,'add')">+</button>
                                <button class="admin-menu-btn delete"
                                    onclick="if(confirm('Delete this item?')) window.location.href='admin_product_action.php?id=<?= $m['menu_id'] ?>'">Delete</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            <?php elseif ($section === 'add_product'):
                $message = '';
                $categories = fetchCategories($conn);

                /* Handle Form Submission */
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $name = trim($_POST['name']);
                    $description = trim($_POST['description']);
                    $category_id = intval($_POST['category']);
                    $stock = intval($_POST['stock']);

                    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'jfif']; // added a new type of image: 'jfif'
                        if (!in_array(strtolower($ext), $allowed)) {
                            $message = "Invalid image type.";
                        } else {
                            $filename = 'uploads/' . time() . '_' . basename($_FILES['image']['name']); // make a new folder name 'uploads' or 
                            if (move_uploaded_file($_FILES['image']['tmp_name'], $filename)) {      // just pick the existing folder name 'Pizzeria'
                                $stmt = $conn->prepare("INSERT INTO menu (name, description, category_id, stock, image, status) VALUES (?,?,?,?,?,1)");
                                $stmt->bind_param("sssis", $name, $description, $category_id, $stock, $filename);
                                if ($stmt->execute()) {
                                    echo "<script>window.location.href='?section=menu';</script>";
                                    exit;
                                } else {
                                    $message = "Database error: failed to add product.";
                                }
                                $stmt->close();
                            } else
                                $message = "Failed to upload image.";
                        }
                    } else
                        $message = "Please upload an image.";
                }
                ?>

                <div class="add-product-container">
                    <h2>Add Product</h2>
                    <?php if ($message)
                        echo "<div class='message'>{$message}</div>"; ?>
                    <form method="post" enctype="multipart/form-data">
                        <input type="text" name="name" placeholder="Product Name" required>
                        <textarea name="description" placeholder="Product Description" rows="4" required></textarea>
                        <select name="category" required>
                            <option value="">Select Category</option>
                            <?php foreach ($categories as $c): ?>
                                <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="number" name="stock" placeholder="Stock Quantity" min="0" required>
                        <input type="file" name="image" accept="image/*" required>
                        <button type="submit">Add Product</button>
                    </form>
                </div>

            <?php endif; ?>

        </div>
    </div>
</body>

</html>

<?php include "footer.php"; ?>