<?php
require 'navbar.php';
require 'admin_check.php';
require 'connectdb.php';

// Validate product ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid product ID.");
}

$product_id = intval($_GET['id']);

// Fetch product
$stmt = $db->prepare("SELECT * FROM products WHERE product_id = :id");
$stmt->bindValue(':id', $product_id, PDO::PARAM_INT);
$stmt->execute();
$product = $stmt->fetch();

if (!$product) {
    die("Product not found.");
}

// Fetch categories
$catStmt = $db->query("SELECT category_id, category_name FROM categories ORDER BY category_name");
$categories = $catStmt->fetchAll();

// Handle update
if (isset($_POST['update_product'])) {

    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = floatval($_POST['price']);
    $stock_quantity = intval($_POST['stock_quantity']);
    $category_id = intval($_POST['category_id']);
    $updated_at = date("Y-m-d H:i:s");

    // Category → folder mapping
    $categoryFolders = [
        1 => "mens",
        2 => "womens",
        3 => "kids",
        4 => "accessories",
        5 => "trainers"
    ];

    // Determine folder based on category
    $folderName = $categoryFolders[$category_id] ?? "misc";

    // Build full path (relative to your PHP files)
    $target_dir = "products/" . $folderName . "/";

    // Ensure folder exists
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Keep old image unless new one uploaded
    $image_url = $product['image_url'];

    if (!empty($_FILES['image']['name'])) {

        $filename = time() . "_" . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $filename;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_url = $target_file; // Save correct path
        }
    }

    // Update query
    $update = $db->prepare("
        UPDATE products
        SET category_id = :category_id,
            name = :name,
            description = :description,
            price = :price,
            stock_quantity = :stock_quantity,
            image_url = :image_url,
            updated_at = :updated_at
        WHERE product_id = :product_id
    ");

    $success = $update->execute([
        ':category_id' => $category_id,
        ':name' => $name,
        ':description' => $description,
        ':price' => $price,
        ':stock_quantity' => $stock_quantity,
        ':image_url' => $image_url,
        ':updated_at' => $updated_at,
        ':product_id' => $product_id
    ]);

    if ($success) {
        header("Location: admin_edit_product.php?id=$product_id&updated=1");
        exit();
    } else {
        $error = "Error updating product.";
    }
}
?>

<div class="admin-container">

    <h1 class="admin-title">Edit Product</h1>

    <?php if (isset($_GET['updated'])): ?>
        <p class="success">Product updated successfully!</p>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="admin-form">

        <label>Category</label>
        <select name="category_id" required>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['category_id'] ?>"
                    <?= ($product['category_id'] == $cat['category_id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat['category_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Product Name</label>
        <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>

        <label>Description</label>
        <textarea name="description" required><?= htmlspecialchars($product['description']) ?></textarea>

        <label>Price (£)</label>
        <input type="number" step="0.01" name="price" value="<?= $product['price'] ?>" required>

        <label>Stock Quantity</label>
        <input type="number" name="stock_quantity" value="<?= $product['stock_quantity'] ?>" required>

        <label>Current Image</label><br>
        <img src="<?= htmlspecialchars($product['image_url']) ?>" width="150" class="edit-thumb"><br><br>

        <label>Upload New Image (optional)</label>
        <input type="file" name="image">

        <button type="submit" name="update_product" class="admin-btn">Update Product</button>
    </form>

</div>

<?php require 'footer.php'; ?>