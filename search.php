<?php
include 'navbar.php';
include 'connectdb.php';

$q = $_GET['q'] ?? '';
$category = $_GET['category'] ?? '';
$min_price = $_GET['min_price'] ?? '';
$max_price = $_GET['max_price'] ?? '';

// Get categories for dropdown
$cat_stmt = $db->query("SELECT * FROM categories");
$categories = $cat_stmt->fetchAll();

// Build search query
$sql = "SELECT * FROM products WHERE 1";
$params = [];

if ($q != '') {
    $sql .= " AND (name LIKE :search OR description LIKE :search)";
    $params['search'] = "%$q%";
}

if ($category != '') {
    $sql .= " AND category_id = :category";
    $params['category'] = $category;
}

if ($min_price != '') {
    $sql .= " AND price >= :min_price";
    $params['min_price'] = $min_price;
}

if ($max_price != '') {
    $sql .= " AND price <= :max_price";
    $params['max_price'] = $max_price;
}

$stmt = $db->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll();

if (empty($products)) {
    header("Location: no_results_found.php?q=" . urlencode($q));
    exit();
}   
?>

<div class="products-container">

<h1 class="products-title">
Search Results
<?php if ($q != ''): ?>
for "<?= htmlspecialchars($q) ?>"
<?php endif; ?>
</h1>

<form method="GET" action="search.php" class="search-filters">

<input type="text" name="q" placeholder="Search..." value="<?= htmlspecialchars($q) ?>">

<select name="category">
<option value="">All Categories</option>

<?php foreach ($categories as $cat): ?>
<option value="<?= $cat['category_id'] ?>"
<?= $category == $cat['category_id'] ? 'selected' : '' ?>>
<?= $cat['category_name'] ?>
</option>
<?php endforeach; ?>

</select>

<input type="number" name="min_price" placeholder="Min Price" value="<?= htmlspecialchars($min_price) ?>">
<input type="number" name="max_price" placeholder="Max Price" value="<?= htmlspecialchars($max_price) ?>">

<button type="submit">Filter</button>

</form>

<?php if (empty($products)): ?>

<p class="no-products">No products found.</p>

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

<?php include 'footer.php'; ?>