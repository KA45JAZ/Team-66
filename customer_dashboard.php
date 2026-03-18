<?php
include 'auth_check.php'; 
include 'connectdb.php';
include 'navbar.php';

// Get logged-in user ID from session
$user_id = $_SESSION['user_id'];


// Get user's basic info
$user_stmt = $db->prepare("SELECT first_name, last_name, email FROM users WHERE user_id = :id");
$user_stmt->execute(['id' => $user_id]);
$user = $user_stmt->fetch();


// Get last 5 orders for this user
$order_stmt = $db->prepare("
    SELECT order_id, order_date, total_amount, status 
    FROM orders 
    WHERE user_id = :id 
    ORDER BY order_date DESC 
    LIMIT 5
");
$order_stmt->execute(['id' => $user_id]);
$orders = $order_stmt->fetchAll();
?>

<div class="dashboard-container">

    
    <div class="dashboard-header">
        <h1>Welcome back, <?= htmlspecialchars($user['first_name']) ?> </h1>
        <h2>Welcome to your account</h2>
    </div>

    <div class="dashboard-layout">

        
        <div class="dashboard-sidebar">
            <a href="customer_dashboard.php">Dashboard</a>
            <a href="profile.php">Profile</a>
            <a href="orders.php">Orders</a>
            <a href="wishlist.php">Wishlist</a>
            <a href="basket.php">Basket</a>
            <a href="change_password.php">Change Password</a>
        </div>

        
        <div class="dashboard-main">

            
            <div class="dashboard-card">
                <h2>Account Overview</h2>
                <p><strong>Name:</strong> <?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
            </div>

            
            <div class="dashboard-card">
                <h2>Recent Orders</h2>

                <?php if (!$orders): ?>
                    <p>Hi, <?= htmlspecialchars($user['first_name']) ?> 
                    you don't have any recent orders. Check out our newest arrivals for men, women & kids! PS When you place an order you'll get updates here.
                    </p>
                <?php else: ?>
                    <table class="orders-table">
                        <tr>
                            <th>ID</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>

                        <?php foreach ($orders as $o): ?>
                            <tr>
                                <td>#<?= $o['order_id'] ?></td>
                                <td><?= date("d M Y", strtotime($o['order_date'])) ?></td>
                                <td>£<?= number_format($o['total_amount'], 2) ?></td>

                                
                                <td>
                                    <span class="status <?= $o['status'] ?>">
                                        <?= ucfirst($o['status']) ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php endif; ?>
            </div>

            <!-- Quick Links -->
            <div class="dashboard-card">
                <h2>Quick Actions</h2>

                <div class="quick-links">
                    <a href="products.php">Shop Now</a>
                    <a href="wishlist.php">View Wishlist</a>
                    <a href="basket.php">Go to Basket</a>
                    <a href="orders.php">View Orders</a>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include 'footer.php'; ?>