<?php
require_once "connectdb.php";

$query = $db->prepare("SELECT * FROM products WHERE category_id = 1");
$query->execute();
$products = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Men's Products - Goodfit</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include "navbar.php"; ?>

<div class="product-listing-container">
    <h1 class="section-title">Men's Collection</h1>

    <div class="product-grid">
        <?php if (empty($products)): ?>
            <p style="color:white; text-align:center;">No men's products available.</p>
        <?php else: ?>
            <?php foreach ($products as $p): ?>
                <div class="product-card">
                    <img src="<?php echo htmlspecialchars($p['image_url']); ?>" alt="">
                    <h3><?php echo htmlspecialchars($p['name']); ?></h3>
                    <p class="price">£<?php echo number_format($p['price'], 2); ?></p>
                    <a href="product.php?id=<?php echo $p['product_id']; ?>" class="add-to-cart">View Product</a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php include "footer.php"; ?>

</body>
</html>