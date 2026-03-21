<?php
session_start();
include 'navbar.php';
include 'connectdb.php';

// Must be logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Validate order ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("<div class='error-page'>Invalid order.</div>");
}

$order_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

// Fetch order (ensure it belongs to this user)
$order_stmt = $db->prepare("
    SELECT * FROM orders 
    WHERE order_id = :oid AND user_id = :uid
");
$order_stmt->execute([
    'oid' => $order_id,
    'uid' => $user_id
]);
$order = $order_stmt->fetch();

if (!$order) {
    die("<div class='error-page'>Order not found.</div>");
}

// Fetch items
$item_stmt = $db->prepare("
    SELECT oi.*, p.name, p.image_url
    FROM order_items oi
    JOIN products p ON oi.product_id = p.product_id
    WHERE oi.order_id = :oid
");
$item_stmt->execute(['oid' => $order_id]);
$items = $item_stmt->fetchAll();
?>

<div class="order-view-container">

    <h1 class="order-view-title">Order #<?= $order_id ?></h1>
    <p class="order-date">Placed on <?= date("d M Y, H:i", strtotime($order['order_date'])) ?></p>

    <div class="order-flex">

        <!-- LEFT: Items -->
        <div class="order-left">
            <h2>Items</h2>

            <?php foreach ($items as $item): ?>
                <div class="order-item">
                    <img src="<?= $item['image_url'] ?>" class="order-img">
                    <div>
                        <p class="order-name"><?= $item['name'] ?></p>
                        <p class="order-qty">Qty: <?= $item['quantity'] ?></p>
                        <p class="order-price">£<?= number_format($item['price_at_purchase'] * $item['quantity'], 2) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>

            <hr>

            <h3 class="order-total">Total Paid: £<?= number_format($order['total_amount'], 2) ?></h3>
        </div>

        <!-- RIGHT: Delivery -->
        <div class="order-right">
            <h2>Delivery Address</h2>

            <p class="address-line"><?= htmlspecialchars($order['full_name']) ?></p>
            <p class="address-line"><?= htmlspecialchars($order['address1']) ?></p>

            <?php if (!empty($order['address2'])): ?>
                <p class="address-line"><?= htmlspecialchars($order['address2']) ?></p>
            <?php endif; ?>

            <p class="address-line"><?= htmlspecialchars($order['city']) ?></p>
            <p class="address-line"><?= htmlspecialchars($order['postcode']) ?></p>

            <p class="address-phone">Phone: <?= htmlspecialchars($order['phone']) ?></p>
        </div>

    </div>

    <a href="orders.php" class="back-btn">Back to Orders</a>

</div>

<?php include 'footer.php'; ?>