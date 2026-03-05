<?php
session_start();

if (!isset($_POST['id']) || !isset($_POST['quantity'])) {
    header("Location: basket.php");
    exit;
}

$id = intval($_POST['id']);
$qty = intval($_POST['quantity']);

if ($qty < 1) $qty = 1;

if (isset($_SESSION['basket'][$id])) {
    $_SESSION['basket'][$id]['quantity'] = $qty;
}

header("Location: basket.php");
exit;
?>