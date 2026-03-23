<?php
if (!isset($_SESSION)) {
    session_start();
}

$basket_count = isset($_SESSION['basket']) ? count($_SESSION['basket']) : 0;
$is_logged_in = isset($_SESSION['user_id']);
$is_admin = $is_logged_in && $_SESSION['role'] === 'admin';
?>

<header class="site-header">

  <div class="top-nav">

    <div class="nav-left">
      <form action="search.php" method="GET">
        <input type="text" name="q" placeholder="Search for Items and Brands" class="search-input">
        <button type="submit" class="search-btn">
          <img src="images/search.png" alt="Search Icon" class="nav-search">
        </button>
      </form>
    </div>

    <div class="nav-center">
      <a href="index.php" class="nav-logo"></a>
    </div>

    <div class="nav-right">

<a href="#" id="theme-toggle" class="nav-icon theme-btn">      
  <img src="images/moon2.png" class="icon-img" alt="Toggle Theme">
  </a href>

  <a href="wishlist.php" class="nav-icon">
    <img src="images/wishlist.png" class="icon-img" alt="Wishlist">
  </a>

  <a href="<?php echo $is_logged_in ? 'customer_dashboard.php' : 'login.php'; ?>" class="nav-icon">
    <img src="images/account.png" class="icon-img" alt="Account">
</a>

  <?php if ($is_admin): ?>
    <a href="admin_dashboard.php" class="nav-icon">
      <img src="images/admin.png" class="icon-img" alt="Admin">
    </a>
  <?php endif; ?>

  <?php if ($is_logged_in): ?>
    <a href="logout.php" class="nav-icon">
      <img src="images/logout.png" class="icon-img" alt="Logout">
    </a>
  <?php endif; ?>

  <a href="basket.php" class="nav-icon">
    <img src="images/basket.png" class="icon-img" alt="Basket">
    <span class="basket-count"><?= $basket_count ?></span>
  </a>

</div>
  </div>

  <nav class="bottom-nav">
    <a href="category.php?cat=1">MEN</a>
    <a href="category.php?cat=2">WOMEN</a>
    <a href="category.php?cat=3">KIDS</a>
    <a href="category.php?cat=4">ACCESSORIES</a>
    <a href="category.php?cat=5">TRAINERS</a>
  </nav>
  <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
    <nav class="bottom-nav">
      <a href="admin_dashboard.php">Admin Dashboard</a>
      <a href="admin_products.php">Manage Products</a>
      <a href="admin_categories.php">Manage Categories</a>
      <a href="admin_orders.php">Manage Orders</a>
    </nav>
  <?php endif; ?>

</header>