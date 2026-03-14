<?php
session_start();
include 'navbar.php';
include 'connectdb.php';

// Validate order ID
if (!isset($_GET['order_id']) || !is_numeric($_GET['order_id'])) {
    die("<div class='error-page'>Invalid order.</div>");
}

$order_id = intval($_GET['order_id']);

// Fetch order
$order_stmt = $db->prepare("SELECT * FROM orders WHERE order_id = :oid AND user_id = :uid");
$order_stmt->execute([
    'oid' => $order_id,
    'uid' => $_SESSION['user_id']
]);
$order = $order_stmt->fetch();

if (!$order) {
    die("<div class='error-page'>Order not found.</div>");
}

// Fetch order items
$item_stmt = $db->prepare("
    SELECT oi.*, p.product_name, p.image_url
    FROM order_items oi
    JOIN products p ON oi.product_id = p.product_id
    WHERE oi.order_id = :oid
");
$item_stmt->execute(['oid' => $order_id]);
$items = $item_stmt->fetchAll();
?>

<div class="success-container">

    <h1 class="success-title">Thank You for Your Order!</h1>

    <p class="success-subtitle">Your order number is <strong>#<?= $order_id ?></strong></p>

    <div class="success-box">

        <h2>Order Summary</h2>

        <?php foreach ($items as $item): ?>
            <div class="success-item">
                <img src="<?= $item['image_url'] ?>" class="success-img">
                <div>
                    <p class="success-name"><?= $item['product_name'] ?></p>
                    <p class="success-qty">Qty: <?= $item['quantity'] ?></p>
                    <p class="success-price">£<?= number_format($item['price'] * $item['quantity'], 2) ?></p>
                </div>
            </div>
        <?php endforeach; ?>

        <hr>

        <h3 class="success-total">Total Paid: £<?= number_format($order['total_price'], 2) ?></h3>

        <p class="success-message">
            Your items will be shipped to:<br>
            <?= htmlspecialchars($order['fullname']) ?><br>
            <?= htmlspecialchars($order['address1']) ?><br>
            <?= htmlspecialchars($order['address2']) ?><br>
            <?= htmlspecialchars($order['city']) ?>, <?= htmlspecialchars($order['postcode']) ?>
        </p>

        <a href="products.php" class="continue-btn">Continue Shopping</a>

    </div>

</div>

<?php include 'footer.php'; ?>