<?php
session_start();
include 'connectdb.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: products.php");
    exit;
}

$product_id = intval($_GET['id']);


$stmt = $db->prepare("SELECT * FROM products WHERE product_id = :id");
$stmt->execute(['id' => $product_id]);
$product = $stmt->fetch();

if (!$product) {
    header("Location: products.php");
    exit;
}

// Create basket if not exists
if (!isset($_SESSION['basket'])) {
    $_SESSION['basket'] = [];
}

// Add or increase quantity
if (isset($_SESSION['basket'][$product_id])) {
    $_SESSION['basket'][$product_id]['quantity'] += 1;
} else {
    $_SESSION['basket'][$product_id] = [
        'id' => $product_id,
        'name' => $product['product_name'],
        'price' => $product['price'],
        'image' => $product['image_url'],
        'quantity' => 1
    ];
}

// Redirect back to product page
header("Location: product.php?id=" . $product_id);
exit;
?>