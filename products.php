<?php
include 'navbar.php';
include 'connectdb.php';

// Fetch all products
$stmt = $db->query("SELECT * FROM products ORDER BY product_id DESC");
$products = $stmt->fetchAll();
?>

<div class="products-container">

    <h1 class="products-title">All Products</h1>

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

</div>

<?php include 'footer.php'; ?>