<?php
// Protect page
include 'auth_check.php';
include 'connectdb.php';

// Get logged-in user
$user_id = $_SESSION['user_id'];

/* ------------------ CHECK ORDER ID ------------------ */

if (!isset($_GET['order_id']) || !is_numeric($_GET['order_id'])) {
    die("Invalid order.");
}

$order_id = intval($_GET['order_id']);

/* ------------------ VERIFY ORDER BELONGS TO USER ------------------ */

$stmt = $db->prepare("
    SELECT status 
    FROM orders 
    WHERE order_id = :order_id 
    AND user_id = :user_id
");

$stmt->execute([
    'order_id' => $order_id,
    'user_id' => $user_id
]);

$order = $stmt->fetch();

if (!$order) {
    die("Order not found.");
}

/* ------------------ CHECK IF ALREADY CANCELLED ------------------ */

if ($order['status'] === 'cancelled') {

    header("Location: orders.php?msg=already_cancelled");
    exit();

}

/* ------------------ UPDATE STATUS ------------------ */

$update = $db->prepare("
    UPDATE orders 
    SET status = 'cancelled' 
    WHERE order_id = :order_id
");

$update->execute([
    'order_id' => $order_id
]);

/* ------------------ REDIRECT ------------------ */

header("Location: orders.php?msg=cancelled");
exit();
?>