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
<!DOCTYPE html>
<html lang="en">

<?php include 'head.php'; ?>
<div class="home-hero">
    <h1>Train Hard. Look Good. Feel Good.</h1>
    <p>Your journey starts with the right gear.</p>
    <a href="products.php" class="hero-btn">Shop Now</a>
</div>



<div class="home-section">
    <h2>Featured Products</h2>

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
<?php include 'chatbot-overlay.php'; ?>
<?php include 'footer.php'; ?>