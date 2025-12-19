<?php
session_start();
include 'pizzeria_db.php';
include 'header.php';

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
.menu-section {
    padding: 60px 80px;
    text-align: center;
}

.menu-title {
    font-size: 42px;
    color: #7a1f12;
}

.menu-subtitle {
    color: #555;
    margin-bottom: 40px;
}

/* CATEGORY BAR */
.menu-categories {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin-bottom: 35px;
    flex-wrap: wrap;
}

.cat-btn {
    padding: 10px 22px;
    border-radius: 30px;
    border: 1px solid #7a1f12;
    background: #fff;
    color: #7a1f12;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s;
}

.cat-btn:hover,
.cat-btn.active {
    background: #7a1f12;
    color: #fff;
}

/* SEARCH BAR */
.menu-search {
    margin: 30px auto 40px;
    max-width: 400px;
}

.menu-search input {
    width: 100%;
    padding: 14px 20px;
    border-radius: 30px;
    border: 1px solid #ddd;
    font-size: 16px;
    outline: none;
}

/* GRID */
.menu-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 30px;
}

/* CARD */
.menu-card {
    position: relative; /* Needed for absolute positioning of button */
    background: #fff;
    border-radius: 20px;
    padding: 25px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    transition: 0.3s;
    min-height: 300px; /* Optional: ensures consistent card height */
}

.menu-card:hover {
    transform: translateY(-10px);
}

.menu-card img {
    width: 180px;
    margin-bottom: 5px;
    border-radius: 20px;
}

.menu-card h3 {
    color: #7a1f12;
    margin-bottom: 5px;
}

.menu-card p {
    font-size: 14px;
    margin-bottom: 5px;
    color: #555;
}

.price {
    display: block;
    font-size: 18px;
    font-weight: bold;
    color: #c0392b;
    margin-bottom: 30px;
}

/* BUTTON */
.menu-btn {
    position: absolute; /* fixes button inside the card */
    bottom: 15px;       /* 10px from bottom */
    left: 50%;          /* center horizontally */
    transform: translateX(-50%);
    background: #7a1f12;
    color: #fff;
    border: none;
    padding: 12px 22px;
    border-radius: 25px;
    cursor: pointer;
    transition: 0.3s;
}

.menu-btn:hover {
    background: #a93226;
}
.notification {
    position: fixed;
    top: 20px;
    right: 20px;
    padding: 15px 25px;
    border-radius: 10px;
    color: #fff;
    background: #4caf50; /* success */
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    z-index: 1000;
    opacity: 0;
    animation: fadeInOut 3s forwards;
}

.notification.error {
    background-color: #f44336;
}

@keyframes fadeInOut {
    0% { opacity: 0; transform: translateY(-20px); }
    10% { opacity: 1; transform: translateY(0); }
    90% { opacity: 1; transform: translateY(0); }
    100% { opacity: 0; transform: translateY(-20px); }
}

</style>

<section class="menu-section">
    <h1 class="menu-title">Our Menu</h1>
    <p class="menu-subtitle">Freshly made, hot, and delicious</p>

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
            <div class="menu-card"
                 data-name="<?= strtolower($row['name']) ?>"
                 data-category="<?= strtolower($row['category']) ?>">

                <img src="<?= $row['image'] ?>" alt="<?= $row['name'] ?>">

                <h3><?= $row['name'] ?></h3>
                <p><?= $row['description'] ?></p>
                <span class="price">₱<?= number_format($row['price'], 2) ?></span>

                <button class="menu-btn" onclick="addToCart(this)">Add to Cart</button>


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
</script>
<script>
function addToCart(button) {
    const card = button.closest('.menu-card');
    const name = card.querySelector('h3').innerText;
    const price = parseFloat(card.querySelector('.price').innerText.replace('₱','').replace(',',''));
    const image = card.querySelector('img').src;

    fetch("add_to_cart.php", {
        method: "POST",
        headers: {"Content-Type": "application/x-www-form-urlencoded"},
        body: `name=${encodeURIComponent(name)}&price=${price}&image=${encodeURIComponent(image)}`
    })
    .then(res => res.json())
    .then(data => {
        showNotification(data.message, data.status); // call global function
    })
    .catch(err => console.error(err));
}

// Global notification function
function showNotification(message, type) {
    const notif = document.createElement('div');
    notif.className = `notification ${type}`;
    notif.textContent = message;
    document.body.appendChild(notif);

    setTimeout(() => notif.remove(), 3000);
}

</script>

<?php include 'footer.php'; ?>
