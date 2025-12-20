<?php
session_start();
include "pizzeria_db.php";
include "header.php";

/* Protect Admin */
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

/* Fetch categories for dropdown */
$categories = [];
$res = $conn->query("SELECT id, name FROM categories ORDER BY name ASC");
if($res) {
    while($row = $res->fetch_assoc()){
        $categories[] = $row;
    }
}

/* Handle Form Submission */
$message = '';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $category_id = intval($_POST['category']);
    $stock = intval($_POST['stock']);
    
    // Handle image upload
    if(isset($_FILES['image']) && $_FILES['image']['error'] === 0){
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $allowed = ['jpg','jpeg','png','webp'];
        if(!in_array(strtolower($ext), $allowed)){
            $message = "Invalid image type.";
        } else {
            $filename = 'uploads/'.time().'_'.basename($_FILES['image']['name']);
            if(move_uploaded_file($_FILES['image']['tmp_name'], $filename)){
                // Insert into database
                $stmt = $conn->prepare("INSERT INTO menu (name, description, category_id, stock, image, status) VALUES (?,?,?,?,?,1)");
                $stmt->bind_param("sssis",$name,$description,$category_id,$stock,$filename);
                if($stmt->execute()){
                    header("Location: ?section=menu"); // back to admin menu
                    exit;
                } else {
                    $message = "Database error: failed to add product.";
                }
                $stmt->close();
            } else {
                $message = "Failed to upload image.";
            }
        }
    } else {
        $message = "Please upload an image.";
    }
}
?>

<style>
.add-product-container {
    max-width: 600px;
    margin: 50px auto;
    background:#fff;
    padding:30px;
    border-radius:20px;
    box-shadow:0 10px 25px rgba(0,0,0,.08);
}
.add-product-container h2 {
    color:#7b1f1f;
    margin-bottom:20px;
    text-align:center;
}
.add-product-container form input,
.add-product-container form textarea,
.add-product-container form select {
    width:100%;
    padding:12px;
    margin-bottom:15px;
    border-radius:8px;
    border:1px solid #ccc;
    font-size:14px;
}
.add-product-container form button {
    background:#c14a1b;
    color:#fff;
    border:none;
    padding:12px 20px;
    border-radius:8px;
    font-weight:bold;
    cursor:pointer;
}
.add-product-container .message {
    color:red;
    text-align:center;
    margin-bottom:10px;
}
</style>

<div class="add-product-container">
    <h2>Add Product</h2>
    <?php if($message) echo "<div class='message'>{$message}</div>"; ?>
    <form method="post" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Product Name" required>
        <textarea name="description" placeholder="Product Description" rows="4" required></textarea>
        <select name="category" required>
            <option value="">Select Category</option>
            <?php foreach($categories as $c): ?>
                <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
            <?php endforeach; ?>
        </select>
        <input type="number" name="stock" placeholder="Stock Quantity" min="0" required>
        <input type="file" name="image" accept="image/*" required>
        <button type="submit">Add Product</button>
    </form>
</div>

<?php include "footer.php"; ?>
