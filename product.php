<?php
include 'navbar.php';
include 'connectdb.php';

// Validate product ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("<div class='error-page'>Invalid product.</div>");
}

$product_id = intval($_GET['id']);

// Fetch product
$stmt = $db->prepare("SELECT * FROM products WHERE product_id = :id");
$stmt->execute(['id' => $product_id]);
$product = $stmt->fetch();

if (!$product) {
    die("<div class='error-page'>Product not found.</div>");
}
?>

<div class="product-page">

    <div class="product-left">
        <img src="<?= $product['image_url'] ?>" alt="<?= $product['product_name'] ?>" class="product-image">
    </div>

    <div class="product-right">
        <h1><?= $product['product_name'] ?></h1>

        <p class="product-price">£<?= number_format($product['price'], 2) ?></p>

        <p class="product-desc"><?= nl2br(htmlspecialchars($product['description'])) ?></p>

        <p class="product-stock">
            <?php if ($product['stock'] > 10): ?>
                <span class="in-stock">In Stock</span>
            <?php elseif ($product['stock'] > 0): ?>
                <span class="low-stock">Low Stock (<?= $product['stock'] ?> left)</span>
            <?php else: ?>
                <span class="out-stock">Out of Stock</span>
            <?php endif; ?>
        </p>

        <?php if ($product['stock'] > 0): ?>
            <a href="add_to_basket.php?id=<?= $product['product_id'] ?>" class="product-btn add-basket">Add to Basket</a>
        <?php endif; ?>

        <a href="add_to_wishlist.php?id=<?= $product['product_id'] ?>" class="product-btn add-wishlist">Add to Wishlist</a>
    </div>

</div>

<?php include 'footer.php'; ?>