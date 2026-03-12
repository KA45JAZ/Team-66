<?php
include 'navbar.php';
include 'connectdb.php';

// Fetch categories
$cat_stmt = $db->query("SELECT category_id, category_name, description FROM categories");
$categories = $cat_stmt->fetchAll();

// Fetch featured products (you can change the logic later)
$prod_stmt = $db->query("SELECT * FROM products LIMIT 6");
$featured = $prod_stmt->fetchAll();
?>

<div class="home-hero">
    <h1>no results found</h1>
    <p>We are sorry but we can’t find any results.</p>
    <a href="products.php" class="hero-btn">Shop Now</a>
</div>



<div class="home-section">
    <h2>KEEP SHOPPING FOR</h2>

    <div class="product-grid">
        <?php foreach ($featured as $p): ?>
            <div class="product-card">
                <img src="<?= $p['image_url'] ?>" alt="<?= $p['name'] ?>">
                <h3><?= $p['name'] ?></h3>
                <p class="price">£<?= number_format($p['price'], 2) ?></p>
                <a href="product.php?id=<?= $p['product_id'] ?>" class="product-btn">View</a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'footer.php'; ?>