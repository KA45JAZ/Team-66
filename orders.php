<?php
session_start();
include 'navbar.php';
include 'connectdb.php';

// Must be logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch all orders for this user
$stmt = $db->prepare("
    SELECT order_id, total_amount, order_date, status
    FROM orders 
    WHERE user_id = :uid 
    ORDER BY order_date DESC
");
$stmt->execute(['uid' => $user_id]);
$orders = $stmt->fetchAll();
?>

<div class="orders-container">

    <h1 class="orders-title">Your Orders</h1>

    <?php if (empty($orders)): ?>
        <p class="no-orders">You haven’t placed any orders yet.</p>
    <?php else: ?>

        <table class="orders-table">
            <tr>
                <th>Order #</th>
                <th>Date</th>
                <th>Total</th>
                <th>Status</th>
                <th>Action</th>

                <th></th>
            </tr>

            <?php foreach ($orders as $o): ?>
                <tr>
                    <td>#<?= $o['order_id'] ?></td>
                    <td><?= date("d M Y, H:i", strtotime($o['order_date'])) ?></td>
                    <td>£<?= number_format($o['total_amount'], 2) ?></td>
                    <td>  <span class="status <?= $o['status'] ?>"> <?= ucfirst($o['status']) ?> </span> </td>
                    <td>
                        <a href="order_view.php?id=<?= $o['order_id'] ?>" class="view-btn">View</a>
                    </td>
                </tr>
            <?php endforeach; ?>

        </table>

    <?php endif; ?>

</div>

<?php include 'footer.php'; ?>