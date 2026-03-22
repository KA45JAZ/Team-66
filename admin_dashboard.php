<?php
require 'navbar.php';
require 'admin_check.php';
require 'connectdb.php';

// Total orders
$totalOrders = $db->query("SELECT COUNT(*) FROM orders")->fetchColumn();
// Total revenue
$totalRevenue = $db->query("SELECT SUM(total_amount) FROM orders")->fetchColumn();
if (!$totalRevenue) $totalRevenue = 0;
// Total customers
$totalCustomers = $db->query("SELECT COUNT(*) FROM users")->fetchColumn();
// Total products
$totalProducts = $db->query("SELECT COUNT(*) FROM products")->fetchColumn();

/* recent orders */
$recentOrdersStmt = $db->query("
    SELECT o.order_id, o.total_amount, o.status, o.order_date,
           CONCAT(u.first_name, ' ', u.last_name) AS full_name
    FROM orders o
    JOIN users u ON o.user_id = u.user_id
    ORDER BY o.order_date DESC
    LIMIT 5
");
$recentOrders = $recentOrdersStmt->fetchAll();

/* -----------------------------
   3. LOW STOCK ALERTS
------------------------------ */

$lowStockStmt = $db->query("
    SELECT product_id, name, stock_quantity
    FROM products
    WHERE stock_quantity < 5
    ORDER BY stock_quantity ASC
");
$lowStock = $lowStockStmt->fetchAll();

/* -----------------------------
   4. ORDER STATUS COUNTS
------------------------------ */

$statusCounts = $db->query("
    SELECT status, COUNT(*) AS count
    FROM orders
    GROUP BY status
")->fetchAll();

$statusMap = [
    'pending' => 0,
    'shipped' => 0,
    'delivered' => 0,
    'cancelled' => 0
];

foreach ($statusCounts as $row) {
    $statusMap[$row['status']] = $row['count'];
}
?>

<div class="admin-container">
    <h1 class="admin-title">Admin Dashboard</h1>

<div class="top-section">
    <!-- LEFT: METRICS -->
    <div class="dashboard-grid">
        <div class="dash-card">
            <h2>Total Orders: <?= $totalOrders ?></h2>
        </div>

        <div class="dash-card">
            <h2>Total Revenue: £<?= number_format($totalRevenue, 2) ?></h2>
        </div>

        <div class="dash-card">
            <h2>Total Customers: <?= $totalCustomers ?></h2>
        </div>

        <div class="dash-card">
            <h2>Total Products: <?= $totalProducts ?></h2>
        </div>
    </div>

    <!-- RIGHT: ORDER STATUS -->
    <div class="status-section">
        <h2>Order Status Overview</h2>
        <div class="status-grid">
            <?php foreach ($statusMap as $status => $count): ?>
                <div class="status-box status-<?= strtolower($status) ?>">
                    <strong><?= $status ?></strong>
                    <span><?= $count ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

    <!-- RECENT ORDERS -->
    <h2>Recent Orders</h2>
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Total (£)</th>
                <th>Status</th>
                <th>Date</th>
                <th>View</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($recentOrders as $order): ?>
                <tr>
                    <td><?= $order['order_id'] ?></td>
                    <td><?= htmlspecialchars($order['full_name']) ?></td>
                    <td>£<?= number_format($order['total_amount'], 2) ?></td>
                    <td><?= $order['status'] ?></td>
                    <td><?= $order['order_date'] ?></td>
                    <td><a href="admin_view_order.php?id=<?= $order['order_id'] ?>" class="table-btn view">View</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- LOW STOCK ALERTS -->
    <h2>Low Stock Alerts</h2>
    <?php if (count($lowStock) === 0): ?>
        <p>No low stock items.</p>
    <?php else: ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Stock</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($lowStock as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td><?= $item['stock_quantity'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php require 'footer.php'; ?>