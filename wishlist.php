

    

<?php
session_start();
include 'navbar.php';
include 'connectdb.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

/* Fetch wishlist items for this user */
$wishlist_stmt = $db->prepare("
    SELECT p.*
    FROM wishlist w
    JOIN products p ON w.product_id = p.product_id
    WHERE w.user_id = ?
");
$wishlist_stmt->execute([$user_id]);
$wishlist_items = $wishlist_stmt->fetchAll();

/* Fetch featured products for suggestions */
$prod_stmt = $db->query("SELECT * FROM products LIMIT 6");
$featured = $prod_stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">

<?php include 'head.php'; ?>

<?php if (count($wishlist_items) > 0): ?>
    <div class="home-section">
        <h2>My Wishlist</h2>

        <div class="product-grid">
            <?php foreach ($wishlist_items as $p): ?>
                <div class="product-card">
                    <img src="<?= $p['image_url'] ?>" alt="<?= htmlspecialchars($p['name']) ?>">
                    <h3><?= htmlspecialchars($p['name']) ?></h3>
                    <p class="price">£<?= number_format($p['price'], 2) ?></p>

                    <a href="product.php?id=<?= $p['product_id'] ?>" class="product-btn">View</a>
                    <a href="add_to_basket.php?id=<?= $p['product_id'] ?>" class="product-btn">Add to Basket</a>

                    <a href="remove_from_wishlist.php?id=<?= $p['product_id'] ?>" class="product-btn remove-btn">
                        Remove
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

<?php else: ?>
    <div class="home-hero">
        <h1>YOUR WISHLIST IS EMPTY</h1>
        <p>
            Tap the "Add to Wishlist" button next to anything you like the look of and
            we'll save it here. Then when you're ready, add it to your bag, check out,
            put it on, and then let's go.
        </p>
        <a href="products.php" class="hero-btn">Shop Now</a>
    </div>

    <div class="home-section">
        <h2>KEEP SHOPPING FOR</h2>

        <div class="product-grid">
            <?php foreach ($featured as $p): ?>
                <div class="product-card">
                    <img src="<?= $p['image_url'] ?>" alt="<?= htmlspecialchars($p['name']) ?>">
                    <h3><?= htmlspecialchars($p['name']) ?></h3>
                    <p class="price">£<?= number_format($p['price'], 2) ?></p>
                    <a href="product.php?id=<?= $p['product_id'] ?>" class="product-btn">View</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>

<?php include 'footer.php'; ?>
