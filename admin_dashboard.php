<?php
require 'navbar.php';
require 'admin_check.php';
require 'connectdb.php';

/* -----------------------------
   1. KEY METRICS
------------------------------ */

// Total orders
$totalOrders = $db->query("SELECT COUNT(*) FROM orders")->fetchColumn();

// Total revenue
$totalRevenue = $db->query("SELECT SUM(total_amount) FROM orders")->fetchColumn();
if (!$totalRevenue) $totalRevenue = 0;

// Total customers
$totalCustomers = $db->query("SELECT COUNT(*) FROM users")->fetchColumn();

// Total products
$totalProducts = $db->query("SELECT COUNT(*) FROM products")->fetchColumn();

/* -----------------------------
   2. RECENT ORDERS
------------------------------ */

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
    'Pending' => 0,
    'Processing' => 0,
    'Shipped' => 0,
    'Completed' => 0,
    'Cancelled' => 0
];

foreach ($statusCounts as $row) {
    $statusMap[$row['status']] = $row['count'];
}
?>

<div class="admin-container">
    <h1 class="admin-title">Admin Dashboard</h1>

    <!-- KEY METRICS -->
    <div class="dashboard-cards">
        <div class="dash-card">
            <h2><?= $totalOrders ?></h2>
            <p>Total Orders</p>
        </div>

        <div class="dash-card">
            <h2>£<?= number_format($totalRevenue, 2) ?></h2>
            <p>Total Revenue</p>
        </div>

        <div class="dash-card">
            <h2><?= $totalCustomers ?></h2>
            <p>Total Customers</p>
        </div>

        <div class="dash-card">
            <h2><?= $totalProducts ?></h2>
            <p>Total Products</p>
        </div>
    </div>

    <!-- ORDER STATUS SUMMARY -->
    <h2>Order Status Overview</h2>
    <div class="status-grid">
        <?php foreach ($statusMap as $status => $count): ?>
            <div class="status-box status-<?= strtolower($status) ?>">
                <strong><?= $status ?></strong>
                <span><?= $count ?></span>
            </div>
        <?php endforeach; ?>
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