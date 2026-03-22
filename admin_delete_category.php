<?php
require 'navbar.php';
require 'admin_check.php';
require 'connectdb.php';

if (!isset($_GET['id'])) {
    header("Location: admin_categories.php?error=No category selected");
    exit;
}

$id = $_GET['id'];

// Optional: Check if category has products
$check = $db->prepare("SELECT COUNT(*) FROM products WHERE category_id = :id");
$check->execute([':id' => $id]);
$count = $check->fetchColumn();

if ($count > 0) {
    header("Location: admin_categories.php?error=Category has products");
    exit;
}

$delete = $db->prepare("DELETE FROM categories WHERE category_id = :id");
$delete->execute([':id' => $id]);

header("Location: admin_categories.php?success=Category deleted");
exit;
?>