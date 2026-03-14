<?php
include 'navbar.php';
include 'connectdb.php';

if (!isset($_GET['q']) || trim($_GET['q']) == '') {
    header("Location: no_results_found.php");
    exit();
}

$search = trim($_GET['q']);

// Search products by name
$stmt = $db->prepare("SELECT * FROM products WHERE name LIKE :search");
$stmt->execute([
    'search' => '%' . $search . '%'
]);

$products = $stmt->fetchAll();

// If nothing found → go to no results page
if (!$products) {
    header("Location: no_results_found.php");
    exit();
}
?>

<div class="products-container">

    <h1 class="products-title">Search Results for "<?= htmlspecialchars($search) ?>"</h1>

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