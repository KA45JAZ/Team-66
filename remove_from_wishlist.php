<?php
session_start();
include 'connectdb.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: wishlist.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$product_id = intval($_GET['id']);

$stmt = $db->prepare("DELETE FROM wishlist WHERE user_id = ? AND product_id = ?");
$stmt->execute([$user_id, $product_id]);

header("Location: wishlist.php");
exit;
?>