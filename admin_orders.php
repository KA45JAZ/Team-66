<?php
require 'navbar.php';
require 'admin_check.php';
require 'connectdb.php';

$stmt = $db->query("
    SELECT o.order_id, o.user_id, o.total_amount, o.status, o.order_date, 
    CONCAT(u.first_name, ' ', u.last_name) AS full_name
    FROM orders o
    JOIN users u ON o.user_id = u.user_id
    ORDER BY o.order_date DESC
");
$orders = $stmt->fetchAll();
?>

<div class="admin-container">
    <h1 class="admin-title">All Orders</h1>

    <table class="admin-table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>User</th>
                <th>Total (£)</th>
                <th>Status</th>
                <th>Date</th>
                <th>View</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= $order['order_id'] ?></td>
                    <td><?= htmlspecialchars($order['full_name']) ?></td>
                    <td>£<?= number_format($order['total_amount'], 2) ?></td>
                    <td>
                        <span class="status-badge status-<?= strtolower($order['status']) ?>">
                            <?= $order['status'] ?>
                        </span>
                    </td>
                    <td><?= $order['order_date'] ?></td>
                    <td>
                        <a href="admin_view_order.php?id=<?= $order['order_id'] ?>" class="table-btn view">
                            View
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require 'footer.php'; ?>