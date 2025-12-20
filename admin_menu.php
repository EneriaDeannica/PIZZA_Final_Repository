<?php
session_start();
include 'pizzeria_db.php';
include "conn.php";
include 'header.php';

// Only allow admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: home.php");
    exit;
}

/* FETCH MENU ITEMS */
$sql = "
SELECT m.*, c.name AS category
FROM menu m
JOIN categories c ON m.category_id = c.id
WHERE m.status = 1
";
$result = $conn->query($sql);
?>

<style>
/* ===== MENU PAGE ===== */
.menu-section { padding: 60px 80px; text-align: center; }
.menu-title { font-size: 42px; color: #7a1f12; }
.menu-subtitle { color: #555; margin-bottom: 50px; }

/* CATEGORY BAR */
.menu-categories { display: flex; justify-content: center; gap: 15px; margin-bottom: 35px; flex-wrap: wrap; }
.cat-btn { padding: 10px 22px; border-radius: 30px; border: 1px solid #7a1f12; background: #fff; color: #7a1f12; font-weight: 600; cursor: pointer; transition: 0.3s; }
.cat-btn:hover, .cat-btn.active { background: #7a1f12; color: #fff; }

/* SEARCH BAR */
.menu-search { margin: 30px auto 40px; max-width: 400px; }
.menu-search input { width: 100%; padding: 14px 20px; border-radius: 30px; border: 1px solid #ddd; font-size: 16px; outline: none; }

/* GRID */
.menu-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px; }

/* CARD */
.menu-card { position: relative; background: url(Background.png); border-radius: 20px; padding: 25px; box-shadow: 0 10px 25px rgba(0,0,0,0.08); transition: transform 0.3s ease, box-shadow 0.3s ease; transform-style: preserve-3d; height: 370px; display: flex; flex-direction: column; align-items: center; }
.menu-card:hover { transform: scale(1.05) translateZ(20px); }
.menu-card img { width: 265px; height: 180px; margin-bottom: 5px; border-radius: 20px; object-fit: cover; display: block; }
.menu-card h3 { color: #7a1f12; margin-bottom: 5px; }
.menu-card p { font-size: 14px; margin-bottom: 5px; color: #555; }

/* ADMIN ACTION BUTTONS */
.admin-actions { position: absolute; bottom: 50px; left: 50%; transform: translateX(-50%); display: flex; gap: 10px; }
.admin-actions button { padding: 8px 15px; border-radius: 20px; border: none; font-weight: bold; cursor: pointer; transition: 0.3s; }
.admin-actions .edit-btn { background: #3498db; color: #fff; }
.admin-actions .edit-btn:hover { background: #2980b9; }
.admin-actions .delete-btn { background: #e74c3c; color: #fff; }
.admin-actions .delete-btn:hover { background: #c0392b; }

/* STOCK CONTROL */
.stock-control { margin-top: 10px; display: flex; justify-content: center; gap: 10px; align-items: center; }
.stock-control button { padding: 5px 10px; border-radius: 5px; border: none; font-weight: bold; cursor: pointer; }
.stock-control .minus { background: #e74c3c; color: #fff; }
.stock-control .plus  { background: #2ecc71; color: #fff; }
</style>

<section class="menu-section">
    <h1 class="menu-title">Admin Menu</h1>
    <p class="menu-subtitle">Manage your menu items</p>

    <!-- CATEGORY BAR -->
    <div class="menu-categories">
        <button class="cat-btn active" data-category="all">All</button>
        <button class="cat-btn" data-category="pizza">Pizza</button>
        <button class="cat-btn" data-category="burger">Burger</button>
        <button class="cat-btn" data-category="beverages">Beverages</button>
        <button class="cat-btn" data-category="pasta">Pasta</button>
        <button class="cat-btn" data-category="dessert">Dessert</button>
    </div>

    <!-- SEARCH BAR -->
    <div class="menu-search">
        <input type="text" id="searchInput" placeholder="Search menu...">
    </div>

    <!-- MENU GRID -->
    <div class="menu-grid" id="menuGrid">
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="menu-card" data-name="<?= strtolower($row['name']) ?>" data-category="<?= strtolower($row['category']) ?>">
                    <img src="<?= $row['image'] ?>" alt="<?= $row['name'] ?>">
                    <h3><?= $row['name'] ?></h3>
                    <p><?= $row['description'] ?></p>

                    <!-- ADMIN ACTIONS -->
                    <div class="admin-actions">
                        <button class="edit-btn" onclick="window.location.href='admin_edit_menu.php?id=<?= $row['menu_id'] ?>'">Edit</button>
                        <button class="delete-btn" onclick="if(confirm('Delete this item?')) window.location.href='admin_delete_menu.php?id=<?= $row['menu_id'] ?>'">Delete</button>
                    </div>

                    <!-- STOCK CONTROL -->
                   <div class="stock-control">
                        <button class="minus" onclick="updateStock(<?= $row['menu_id'] ?>,'minus')">−</button>
                        <span id="stock-<?= $row['menu_id'] ?>"><?= $row['stock'] ?></span>
                        <button class="plus" onclick="updateStock(<?= $row['menu_id'] ?>,'add')">+</button>
                    </div>

                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No menu items found.</p>
        <?php endif; ?>
    </div>
</section>

<script>
const searchInput = document.getElementById("searchInput");
const menuCards = document.querySelectorAll(".menu-card");
const categoryButtons = document.querySelectorAll(".cat-btn");
let activeCategory = "all";

// CATEGORY FILTER
categoryButtons.forEach(btn => {
    btn.addEventListener("click", () => {
        categoryButtons.forEach(b => b.classList.remove("active"));
        btn.classList.add("active");
        activeCategory = btn.dataset.category;
        filterMenu();
    });
});

// SEARCH FILTER
searchInput.addEventListener("keyup", filterMenu);

function filterMenu() {
    const searchValue = searchInput.value.toLowerCase();
    menuCards.forEach(card => {
        const name = card.dataset.name;
        const category = card.dataset.category;
        const matchSearch = name.includes(searchValue);
        const matchCategory = activeCategory === "all" || category === activeCategory;
        card.style.display = (matchSearch && matchCategory) ? "block" : "none";
    });
}

// SINGLE STOCK FUNCTION FOR AJAX
function updateStock(menuId, action) {
    fetch('admin_stock_action.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `id=${menuId}&action=${action}`
    })
    .then(res => res.text())
    .then(res => {
        if(res === 'success') {
            const stockEl = document.getElementById('stock-' + menuId);
            let stock = parseInt(stockEl.innerText);
            stock = action === 'add' ? stock + 1 : Math.max(0, stock - 1);
            stockEl.innerText = stock; // update UI
        } else {
            alert('Failed to update stock: ' + res);
        }
    })
    .catch(() => alert('Error connecting to server.'));
}

</script>

<?php include 'footer.php'; ?>
