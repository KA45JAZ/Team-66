<?php
session_start();
require_once "connectdb.php";



$category = $_GET['cat'] ?? '';

$validCategories = ["Men", "Women", "Kids", "Trainers", "Accessories"];

if (!in_array($category, $validCategories)) {
    die("Invalid category.");
}

$stmt = $db->prepare("SELECT * FROM products WHERE category = :category");
$stmt->bindParam(":category", $category);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $category; ?> - Category</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<?php include "navbar.php"; ?>

<div class="content">
    <h1 class="page-title"><?php echo $category; ?></h1>

    <div class="product-grid">
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $p): ?>
                <div class="product-card">
                    <img src="<?php echo $p['image_path']; ?>" alt="">
                    <h3><?php echo htmlspecialchars($p['product_name']); ?></h3>
                    <p>£<?php echo number_format($p['price'], 2); ?></p>

                    <form action="basket.php" method="POST">
                        <input type="hidden" name="product_id" value="<?php echo $p['id']; ?>">
                        <button type="submit" class="btn">Add to Basket</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No products found in this category.</p>
        <?php endif; ?>
    </div>
</div>

<?php include "footer.php"; ?>
</body>
</html>
