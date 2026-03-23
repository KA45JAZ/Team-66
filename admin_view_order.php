<?php
require 'navbar.php';
require 'admin_check.php';
require 'connectdb.php';

if (!isset($_GET['id'])) {
    header("Location: admin_orders.php?error=No order selected");
    exit;
}

$order_id = $_GET['id'];

// Fetch order
$stmt = $db->prepare("
    SELECT o.*, CONCAT(u.first_name, ' ', u.last_name) AS full_name, u.email
    FROM orders o
    JOIN users u ON o.user_id = u.user_id
    WHERE o.order_id = :id
");
$stmt->execute([':id' => $order_id]);
$order = $stmt->fetch();

if (!$order) {
    header("Location: admin_orders.php?error=Order not found");
    exit;
}

// Fetch order items
$itemStmt = $db->prepare("
    SELECT oi.*, p.name
    FROM order_items oi
    JOIN products p ON oi.product_id = p.product_id
    WHERE oi.order_id = :id
");
$itemStmt->execute([':id' => $order_id]);
$items = $itemStmt->fetchAll();

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newStatus = $_POST['status'];

    $update = $db->prepare("
        UPDATE orders SET status = :status WHERE order_id = :id
    ");
    $update->execute([
        ':status' => $newStatus,
        ':id' => $order_id
    ]);

    header("Location: admin_view_order.php?id=$order_id&success=Status updated");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<?php include 'head.php'; ?>
<div class="admin-container">
    <h1 class="admin-title">Order #<?= $order_id ?></h1>

    <h2>Customer Info</h2>
    <p><strong>Name:</strong> <?= htmlspecialchars($order['full_name']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($order['email']) ?></p>
    <p><strong>Phone:</strong> <?= htmlspecialchars($order['phone']) ?></p>

    <h2>Shipping Address</h2>
    <p><?= htmlspecialchars($order['address1']) ?></p>
    <?php if (!empty($order['address2'])): ?>
        <p><?= htmlspecialchars($order['address2']) ?></p>
    <?php endif; ?>
    <p><?= htmlspecialchars($order['city']) ?></p>
    <p><?= htmlspecialchars($order['postcode']) ?></p>

    <h2>Order Details</h2>
    <p><strong>Date:</strong> <?= $order['order_date'] ?></p>
    <p><strong>Status:</strong> <?= $order['status'] ?></p>

    <h2>Items</h2>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Qty</th>
                <th>Price (£)</th>
                <th>Total (£)</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td><?= $item['quantity'] ?></td>
                    <td>£<?= number_format($item['price_at_purchase'], 2) ?></td>
                    <td>£<?= number_format($item['price_at_purchase'] * $item['quantity'], 2) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Order Summary</h2>
    <p><strong>Total Amount:</strong> £<?= number_format($order['total_amount'], 2) ?></p>

    <h2>Update Status</h2>
    <form method="POST" class="admin-form">
        <select name="status" required>
            <?php
            $statuses = ['Pending', 'Shipped', 'Delivered', 'Cancelled'];
            foreach ($statuses as $status):
            ?>
                <option value="<?= $status ?>" <?= $order['status'] === $status ? 'selected' : '' ?>>
                    <?= $status ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit" class="admin-btn edit-btn">Update Status</button>
    </form>
</div>

<?php require 'footer.php'; ?>