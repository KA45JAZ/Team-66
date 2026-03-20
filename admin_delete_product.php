<?php
require 'navbar.php';
require 'admin_check.php';
require 'connectdb.php';

// Category folder mapping
$categoryFolders = [
    1 => 'mens',
    2 => 'womens',
    3 => 'kids',
    4 => 'accessories',
    5 => 'trainers'
];

// Ensure ID exists
if (!isset($_GET['id'])) {
    header("Location: admin_products.php?error=No product selected");
    exit;
}

$product_id = $_GET['id'];

// Fetch product
$stmt = $db->prepare("SELECT * FROM products WHERE product_id = :id");
$stmt->execute([':id' => $product_id]);
$product = $stmt->fetch();

if (!$product) {
    header("Location: admin_products.php?error=Product not found");
    exit;
}

// Delete image file
$imagePath = $product['image_url'];

if (file_exists($imagePath)) {
    unlink($imagePath);
}

// Delete product from DB
$delete = $db->prepare("DELETE FROM products WHERE product_id = :id");
$delete->execute([':id' => $product_id]);

header("Location: admin_products.php?success=Product deleted");
exit;
?>