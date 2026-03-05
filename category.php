<?php
include 'navbar.php';
include 'connectdb.php';

// Validate category ID
if (!isset($_GET['cat']) || !is_numeric($_GET['cat'])) {
    die("<div class='error-page'>Invalid category.</div>");
}

$cat_id = intval($_GET['cat']);

// Fetch category name
$cat_stmt = $db->prepare("SELECT category_name FROM categories WHERE category_id = :id");
$cat_stmt->execute(['id' => $cat_id]);
$category = $cat_stmt->fetch();

if (!$category) {
    die("<div class='error-page'>Category not found.</div>");
}

// Fetch products in this category
$prod_stmt = $db->prepare("SELECT * FROM products WHERE category_id = :id ORDER BY product_id DESC");
$prod_stmt->execute(['id' => $cat_id]);
$products = $prod_stmt->fetchAll();
?>

<div class="products-container">

    <h1 class="products-title"><?= htmlspecialchars($category['category_name']) ?></h1>

    <?php if (empty($products)): ?>
        <p class="no-products">No products available in this category.</p>
    <?php else: ?>
        <div class="product-grid">
            <?php foreach ($products as $p): ?>
                <div class="product-card">
                    <img src="<?= $p['image_url'] ?>" alt="<?= $p['product_name'] ?>">

                    <h3><?= $p['product_name'] ?></h3>

                    <p class="price">£<?= number_format($p['price'], 2) ?></p>

                    <a href="product.php?id=<?= $p['product_id'] ?>" class="product-btn">View Product</a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>

<?php include 'footer.php'; ?>