<?php
include 'navbar.php';
include 'connectdb.php';

// Get filter values from GET
$category = $_GET['category'] ?? '';
$min_price = $_GET['min_price'] ?? '';
$max_price = $_GET['max_price'] ?? '';

// Fetch all categories for the dropdown
$cat_stmt = $db->query("SELECT * FROM categories");
$categories = $cat_stmt->fetchAll();

// Build query with filters
$sql = "SELECT * FROM products WHERE 1";
$params = [];

if ($category != '') {
    $sql .= " AND category_id = :category";
    $params['category'] = $category;
}

if ($min_price != '') {
    $sql .= " AND price >= :min_price";
    $params['min_price'] = $min_price;
}

if ($max_price != '') {
    $sql .= " AND price <= :max_price";
    $params['max_price'] = $max_price;
}

$sql .= " ORDER BY product_id DESC";

$stmt = $db->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll();
?>

<div class="products-container">

    <h1 class="products-title">All Products</h1>

    <!-- Filter form -->
    <form method="GET" class="search-filters">

        <select name="category">
            <option value="">All Categories</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['category_id'] ?>" <?= $category == $cat['category_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat['category_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <input type="number" name="min_price" placeholder="Min Price" value="<?= htmlspecialchars($min_price) ?>">
        <input type="number" name="max_price" placeholder="Max Price" value="<?= htmlspecialchars($max_price) ?>">

        <button type="submit">Filter</button>
    </form>

    <!-- Products grid -->
    <?php if (empty($products)): ?>
        <p class="no-products">No products found.</p>
    <?php else: ?>
        <div class="product-grid">
            <?php foreach ($products as $p): ?>
                <div class="product-card">
                    <img src="<?= $p['image_url'] ?>" alt="<?= $p['name'] ?>">

                    <h3><?= $p['name'] ?></h3>

                    <p class="price">£<?= number_format($p['price'], 2) ?></p>

                    <a href="product.php?id=<?= $p['product_id'] ?>" class="product-btn">View Product</a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>

<?php include 'footer.php'; ?>