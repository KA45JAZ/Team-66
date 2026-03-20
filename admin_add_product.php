<?php
require 'navbar.php';
require 'admin_check.php';
require 'connectdb.php';

// Fetch categories for dropdown
$catStmt = $db->query("SELECT category_id, category_name FROM categories ORDER BY category_name");
$categories = $catStmt->fetchAll();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock_quantity'];
    $category_id = $_POST['category_id'];

    // Map category_id → folder name
    $categoryFolders = [
        1 => 'mens',
        2 => 'womens',
        3 => 'kids',
        4 => 'accessories',
        5 => 'trainers'
    ];

    $folder = $categoryFolders[$category_id];

    // Handle image upload
    $imageFile = $_FILES['image'];

    if ($imageFile['error'] === 0) {

        $filename = basename($imageFile['name']);
        $targetPath = "products/$folder/" . $filename;

        // Move uploaded file
        if (move_uploaded_file($imageFile['tmp_name'], $targetPath)) {

            // Insert into database
            $stmt = $db->prepare("
                INSERT INTO products 
                (category_id, name, description, price, stock_quantity, image_url, created_at, updated_at)
                VALUES 
                (:category_id, :name, :description, :price, :stock, :image_url, NOW(), NOW())
            ");

            $stmt->execute([
                ':category_id' => $category_id,
                ':name' => $name,
                ':description' => $description,
                ':price' => $price,
                ':stock' => $stock,
                ':image_url' => $targetPath
            ]);

            header("Location: admin_products.php?success=Product added");
            exit;

        } else {
            $error = "Failed to upload image.";
        }

    } else {
        $error = "Image upload error.";
    }
}
?>

<div class="admin-container">
    <h1 class="admin-title">Add New Product</h1>

    <?php if (!empty($error)): ?>
        <p class="error-msg"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="admin-form">

        <label>Product Name</label>
        <input type="text" name="name" required>

        <label>Description</label>
        <textarea name="description" required></textarea>

        <label>Price (£)</label>
        <input type="number" step="0.01" name="price" required>

        <label>Stock Quantity</label>
        <input type="number" name="stock_quantity" required>

        <label>Category</label>
        <select name="category_id" required>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['category_id'] ?>">
                    <?= htmlspecialchars($cat['category_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Product Image</label>
        <input type="file" name="image" accept="image/*" required>

        <button type="submit" class="admin-btn add-btn">Add Product</button>
    </form>
</div>

<?php require 'footer.php'; ?>