<?php
require 'navbar.php';
require 'admin_check.php';
require 'connectdb.php';


// Build base query
$query = "
    SELECT p.product_id, p.name, p.description, p.price, p.stock_quantity, 
           p.image_url, p.created_at, p.updated_at,
           c.category_name
    FROM products p
    LEFT JOIN categories c ON p.category_id = c.category_id
    WHERE 1
";

// Search filter
$search = $_GET['search'] ?? '';
if (!empty($search)) {
    $query .= " AND p.name LIKE :search ";
}

// Category filter
$categoryFilter = $_GET['category'] ?? '';
if (!empty($categoryFilter)) {
    $query .= " AND p.category_id = :category ";
}

// Stock filter
$stockFilter = $_GET['stock'] ?? '';
if ($stockFilter === 'low') {
    $query .= " AND p.stock_quantity < 5 AND p.stock_quantity > 0 ";
} elseif ($stockFilter === 'out') {
    $query .= " AND p.stock_quantity = 0 ";
}

// Prepare and bind
$stmt = $db->prepare($query);

if (!empty($search)) {
    $stmt->bindValue(':search', "%$search%");
}
if (!empty($categoryFilter)) {
    $stmt->bindValue(':category', $categoryFilter);
}

$stmt->execute();
$products = $stmt->fetchAll();

// Fetch categories for dropdown
$catStmt = $db->query("SELECT category_id, category_name FROM categories ORDER BY category_name");
$categories = $catStmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">

<?php include 'head.php'; ?>
<div class="admin-container">

    <h1 class="admin-title">Manage Products</h1>

    <!-- FILTERS -->
    <form method="GET" class="filter-form">
        <input type="text" name="search" placeholder="Search by name..." value="<?= htmlspecialchars($search) ?>">

        <select name="category">
            <option value="">All Categories</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['category_id'] ?>" 
                    <?= ($categoryFilter == $cat['category_id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat['category_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <select name="stock">
            <option value="">Stock Status</option>
            <option value="low" <?= ($stockFilter === 'low') ? 'selected' : '' ?>>Low Stock</option>
            <option value="out" <?= ($stockFilter === 'out') ? 'selected' : '' ?>>Out of Stock</option>
        </select>

        <button type="submit" class="admin-btn">Filter</button>
        <a href="admin_add_product.php" class="admin-btn add-btn">Add Product</a>
    </form>

    <!-- PRODUCT TABLE -->
    <table class="admin-table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price (£)</th>
                <th>Stock</th>
                <th>Created</th>
                <th>Updated</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            <?php if (empty($products)): ?>
                <tr><td colspan="8" class="no-results">No products found</td></tr>
            <?php else: ?>
                <?php foreach ($products as $p): ?>

                    <?php
                        // Stock highlighting
                        $rowClass = '';
                        if ($p['stock_quantity'] == 0) {
                            $rowClass = 'out-stock';
                        } elseif ($p['stock_quantity'] < 5) {
                            $rowClass = 'low-stock';
                        }
                    ?>

                    <tr class="<?= $rowClass ?>">
                        <td>
                            <img src="<?= htmlspecialchars($p['image_url']) ?>" class="product-thumb">
                        </td>
                        <td><?= htmlspecialchars($p['name']) ?></td>
                        <td><?= htmlspecialchars($p['category_name']) ?></td>
                        <td><?= number_format($p['price'], 2) ?></td>
                        <td><?= $p['stock_quantity'] ?></td>
                        <td><?= $p['created_at'] ?></td>
                        <td><?= $p['updated_at'] ?></td>
                        <td>
                            <a href="admin_edit_product.php?id=<?= $p['product_id'] ?>" class="table-btn edit">Edit</a>
                            <a href="admin_delete_product.php?id=<?= $p['product_id'] ?>" 
                               class="table-btn delete"
                               onclick="return confirm('Are you sure you want to delete this product?')">
                               Delete
                            </a>
                        </td>
                    </tr>

                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

</div>

<?php require 'footer.php'; ?>