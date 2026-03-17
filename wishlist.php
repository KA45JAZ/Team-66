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
    <h1>YOUR WISHLIST IS EMPTY</h1>
    <p>Tap the "Add to Wishlist" button next to anything you like the look of and we'll save it here. Then when you're ready, add it to your bag, check out, put it on, and then let's go</p>
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

<?php include 'footer.php'; ?> hellow world