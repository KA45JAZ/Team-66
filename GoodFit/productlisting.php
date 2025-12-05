<?php
require_once "connectdb.php";

// Fetch all products
$query = $db->prepare("SELECT * FROM products ORDER BY created_at DESC");
$query->execute();
$products = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Listing</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="GoodFit/css/style.css">
</head>

<body>

    <!-- ✅ NAVBAR -->
    <?php include "navbar.php"; ?>

    <!-- ✅ CATEGORY BAR -->
    <div class="nav-bottom">
        <div>
            <img src="GoodFit/assets/menu_icon.png" width="25px" alt="">
            <p>All</p>
        </div>
        <p><a href="men.php">Men</a></p>
        <p><a href="women.php">Women</a></p>
        <p><a href="kids.php">Kids</a></p>
        <p><a href="accessories.php">Accessories</a></p>
        <p><a href="trainers.php">Trainers</a></p>
    </div>

    <!-- ✅ HEADER IMAGES -->
    <div class="scroll-bar">
        <a href="#" class="control_pre">&#129144;</a>
        <a href="#" class="control_next">&#129146;</a>

        <ul>
            <img src="GoodFit/assets/Men's fashion.png" class="header-img" alt="">
            <img src="GoodFit/assets/Women's fashion.png" class="header-img" alt="">
            <img src="GoodFit/assets/Kid's fashion.png" class="header-img" alt="">
            <img src="GoodFit/assets/Accessories.png" class="header-img" alt="">
        </ul>
    </div>

    <!-- ✅ PRODUCT LISTING (DYNAMIC) -->
    <div class="product-scroll-price">
        <h2>Shop</h2>

        <div class="products">

            <?php if (empty($products)): ?>
                <p style="color:white; text-align:center;">No products available.</p>
            <?php else: ?>
                <?php foreach ($products as $p): ?>
                    <div class="product-card">

                        <div class="product-img-cont">
                            <img src="<?php echo htmlspecialchars($p['image_url']); ?>" alt="">
                        </div>

                        <p class="product-price">
                            £ <span><?php echo number_format($p['price'], 2); ?></span>
                        </p>

                        <h4><?php echo htmlspecialchars($p['name']); ?></h4>

                        <a href="product.php?id=<?php echo $p['product_id']; ?>" class="view-btn">
                            View Product
                        </a>

                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

        </div>
    </div>

    <!-- ✅ FOOTER -->
    <?php include "footer.php"; ?>

    <script src="GoodFit/JavaScipt/script.js"></script>

</body>

</html>