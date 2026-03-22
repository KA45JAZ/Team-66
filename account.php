<?php
    session_start();
    include 'navbar.php';
    include 'connectdb.php';

    //check if user is logged in
    if (!isset($_SESSION['user_id'])){
        die("<div class='error-page'>You must be logged in to view your profile.</div>");
    }

    $user_id = $_SESSION['user_id'];

    $stmt = $db->prepare("
        SELECT first_name, last_name, email, phone, role
        FROM users
        WHERE user_id = :user_id
    ");
    $stmt->execute(['user_id' => $user_id]);
    $user = $stmt->fetch();

    if(!$user){
        die("<div class='error-page'>User not found.</div>");
    }

    //Getting the reviews
    $review_stmt = $db->prepare("
        SELECT r.rating, r.review_text, r.review_date, p.name AS product_name
        FROM reviews r
        JOIN products p ON r.product_id = p.product_id
        WHERE r.user_id = :user_id
        ORDER BY r.review_date DESC
    ");
    $review_stmt->execute(['user_id'=>$user_id]);
    $user_reviews = $review_stmt->fetchALL();
?>

<div class="account-page">
    <h1>My Account</h1>

    <div class="account-section">
        <h2>Customer Personal Information</h2>
        <p><strong>First Name: </strong> <?= htmlspecialchars($user['first_name']) ?></p>
        <p><strong>Last Name: </strong> <?= htmlspecialchars($user['last_name']) ?></p>
        <p><strong>Email: </strong> <?= htmlspecialchars($user['email']) ?> </p>
        <p><strong>Phone Number: </strong> <?= htmlspecialchars($user['phone']) ?></p>
        <p><strong>Role: </strong> <?= htmlspecialchars($user['role']) ?></p>
    </div>

    <div class="account-section">
        <h2>My Reviews</h2>

        <?php if(count($user_reviews)>0): ?>
            <?php foreach ($user_reviews as $review): ?>

                <div class="review-box">
                    <p><strong><?= htmlspecialchars($review['product_name']) ?></strong></p>
                    <div class="review-rating">
                        <?php for($i=1; $i<=5; $i++): ?>
                            <?= $i <= $review['rating'] ? "⭐" : "☆" ?>
                        <?php endfor; ?>
                    </div>

                    <p><?= htmlspecialchars($review['review_text']) ?></p>

                    <p class="review-date">
                        <?= date("d M Y", strtotime($review['review_date'])) ?>
                    </p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>You have not written any reviews yet.</p>
        <?php endif; ?>
    </div>
    
    <div class="account-links">
        <a href="update_account.php" class="account-btn">Edit Personal Information</a>
        <a href="orders.php" class="account-btn">Order History</a>
        <a href="account_settings.php" class="account-btn">Account Settings</a>
        <a href="wishlist.php" class="account-btn">Wishlist</a>
    </div>
</div>

<?php include 'footer.php'; ?>
