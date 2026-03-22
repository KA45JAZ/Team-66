<?php
session_start();
include 'navbar.php';
include 'connectdb.php';

// Must be logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Basket must not be empty
$basket = isset($_SESSION['basket']) ? $_SESSION['basket'] : [];
if (empty($basket)) {
    header("Location: basket.php");
    exit;
}

// Calculate total
$total = 0;
foreach ($basket as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>

<div class="checkout-container">

    <h1 class="checkout-title">Checkout</h1>

    <div class="checkout-flex">

        <!-- LEFT: Delivery Form -->
        <div class="checkout-left">
            <h2>Delivery Details</h2>

            <form action="place_order.php" method="POST" class="checkout-form">

                <label>Full Name</label>
                <input type="text" name="full_name" required>

                <label>Address Line 1</label>
                <input type="text" name="address1" required>

                <label>Address Line 2 (optional)</label>
                <input type="text" name="address2">

                <label>City</label>
                <input type="text" name="city" required>

                <label>Postcode</label>
                <input type="text" name="postcode" required>

                <label>Phone Number</label>
                <input type="text" name="phone" required>

                <button type="submit" class="checkout-btn">Place Order</button>
            </form>
        </div>

        <!-- RIGHT: Order Summary -->
        <div class="checkout-right">
            <h2>Order Summary</h2>

            <div class="summary-box">
                <?php foreach ($basket as $item): ?>
                    <div class="summary-item">
                        <img src="<?= $item['image'] ?>" class="summary-img">
                        <div>
                            <p class="summary-name"><?= $item['name'] ?></p>
                            <p class="summary-qty">Qty: <?= $item['quantity'] ?></p>
                            <p class="summary-price">£<?= number_format($item['price'] * $item['quantity'], 2) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>

                <hr>

                <h3 class="summary-total">Total: £<?= number_format($total, 2) ?></h3>
            </div>
        </div>

    </div>

</div>

<?php include 'footer.php'; ?>