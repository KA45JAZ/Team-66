<?php
if (!isset($_SESSION)) {
    session_start();
}

// Basket count (if you are storing basket items in $_SESSION['basket'])
$basket_count = isset($_SESSION['basket']) ? count($_SESSION['basket']) : 0;

// Check login status
$is_logged_in = isset($_SESSION['user_id']);
?>
    
<header class="site-header">
  <div class="top-nav">
    <div class="nav-left">
      <!-- search -->
      <form action="search.php" method="GET">
        <input type="text" name="q" placeholder="Search for Items and Brands" class="search-input">
        <button type="submit" class="search-btn">🔍</button>
      </form>
    </div>

    <div class="nav-center">
      <a href="index.php">
        <img src="logo/GoodFit_Logo.png" alt="GoodFit Logo" class="nav-logo">
      </a>
    </div>

    <div class="nav-right">
      <!-- wishlist/account/basket -->
      <a href="wishlist.php" class="nav-icon"><img src="images/wishlist.png" class="icon-img" alt="Wishlist"></a>
      <a href="<?php echo $is_logged_in ? 'account.php' : 'login.php'; ?>" class="nav-icon"><img src="images/account.png" class="icon-img" alt="Account"></a>
      <a href="basket.php" class="nav-icon"><img src="images/basket.png" class="icon-img" alt="Basket"><span class="basket-count"><?= $basket_count ?></span></a>
    </div>
  </div>

  <!-- CATEGORIES: centered under the logo -->
  <nav class="bottom-nav">
    <a href="men.php">MEN</a>
    <a href="women.php">WOMEN</a>
    <a href="kids.php">KIDS</a>
    <a href="accessories.php">ACCESSORIES</a>
    <a href="trainers.php">TRAINERS</a>
  </nav>
</header>
