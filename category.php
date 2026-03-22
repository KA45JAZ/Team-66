<?php
include 'navbar.php';
include 'connectdb.php';

// Validate category ID
if (!isset($_GET['cat']) || !is_numeric($_GET['cat'])) {
    die("<div class='error-page'>Invalid category.</div>");
}

$cat_id = intval($_GET['cat']);

// Get price filters
$min_price = $_GET['min_price'] ?? '';
$max_price = $_GET['max_price'] ?? '';

// Fetch category name
$cat_stmt = $db->prepare("SELECT category_name FROM categories WHERE category_id = :id");
$cat_stmt->execute(['id' => $cat_id]);
$category = $cat_stmt->fetch();

if (!$category) {
    die("<div class='error-page'>Category not found.</div>");
}

// Build product query
$sql = "SELECT * FROM products WHERE category_id = :cat";
$params = ['cat' => $cat_id];

if ($min_price != '') {
    $sql .= " AND price >= :min_price";
    $params['min_price'] = $min_price;
}

if ($max_price != '') {
    $sql .= " AND price <= :max_price";
    $params['max_price'] = $max_price;
}

$sql .= " ORDER BY product_id DESC";

$prod_stmt = $db->prepare($sql);
$prod_stmt->execute($params);
$products = $prod_stmt->fetchAll();
?>

<div class="products-container">

<h1 class="products-title"><?= htmlspecialchars($category['category_name']) ?></h1>

<form method="GET" class="search-filters">

<input type="hidden" name="cat" value="<?= $cat_id ?>">

<input type="number" name="min_price" placeholder="Min Price"
value="<?= htmlspecialchars($min_price) ?>">

<input type="number" name="max_price" placeholder="Max Price"
value="<?= htmlspecialchars($max_price) ?>">

<button type="submit">Filter</button>

</form>

<?php if (empty($products)): ?>

<p class="no-products">No products available in this category.</p>

<?php else: ?>

<div class="product-grid">

<?php foreach ($products as $p): ?>

<div class="product-card">

<img src="<?= $p['image_url'] ?>" alt="<?= $p['name'] ?>">

<h3><?= $p['name'] ?></h3>

<p class="price">£<?= number_format($p['price'], 2) ?></p>

<a href="product.php?id=<?= $p['product_id'] ?>" class="product-btn">
View Product
</a>

</div>

<?php endforeach; ?>

</div>

<?php endif; ?>

</div>
<?php include 'chatbot-overlay.php'; ?>

<?php include 'footer.php'; ?>