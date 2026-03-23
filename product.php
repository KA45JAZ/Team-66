<?php
include 'navbar.php';
include 'connectdb.php';

// Validate product ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("<div class='error-page'>Invalid product.</div>");
}

$product_id = intval($_GET['id']);

// Fetch product
$stmt = $db->prepare("SELECT * FROM products WHERE product_id = :id");
$stmt->execute(['id' => $product_id]);
$product = $stmt->fetch();

if (!$product) {
    die("<div class='error-page'>Product not found.</div>");
}

// Fetch reviews
$review_stmt = $db->prepare("
    SELECT r.rating, r.review_text, r.review_date,
           CONCAT(u.first_name, ' ', u.last_name) AS reviewer_name
    FROM reviews r
    JOIN users u ON r.user_id = u.user_id
    WHERE r.product_id = :pid
    ORDER BY r.review_date DESC
");
$review_stmt->execute(['pid' => $product_id]);
$reviews = $review_stmt->fetchAll();

// Get average rating
$avg_stmt = $db->prepare("
    SELECT AVG(rating) AS avg_rating, COUNT(*) AS total_reviews
    FROM reviews
    WHERE product_id = :pid
");
$avg_stmt->execute(['pid' => $product_id]);
$rating_data = $avg_stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">

<?php include 'head.php'; ?>
<div class="product-page">

    <div class="product-left">
        <img src="<?= $product['image_url'] ?>" alt="<?= $product['name'] ?>" class="product-image">
    </div>

    <div class="product-right">
        <h1><?= $product['name'] ?></h1>

        <p class="product-price">£<?= number_format($product['price'], 2) ?></p>

        <div class="product-rating">
            <?php if ($rating_data['total_reviews'] > 0): ?>
                <p class="rating-score">
                    ⭐ <?= number_format($rating_data['avg_rating'],1) ?>/5
                    (<?= $rating_data['total_reviews'] ?> reviews)
                </p>
            <?php else: ?>
                <p>No reviews yet</p>
            <?php endif; ?>
        </div>

        <p class="product-desc"><?= nl2br(htmlspecialchars($product['description'])) ?></p>

        <p class="product-stock">
            <?php if ($product['stock_quantity'] > 10): ?>
                <span class="in-stock">In Stock</span>
            <?php elseif ($product['stock_quantity'] > 0): ?>
                <span class="low-stock">Low Stock (<?= $product['stock_quantity'] ?> left)</span>
            <?php else: ?>
                <span class="out-stock">Out of Stock</span>
            <?php endif; ?>
        </p>

        <?php if ($product['stock_quantity'] > 0): ?>
            <a href="add_to_basket.php?id=<?= $product['product_id'] ?>" class="product-btn add-basket">Add to Basket</a>
        <?php endif; ?>

        <a href="add_to_wishlist.php?id=<?= $product['product_id'] ?>" class="product-btn">Add to Wishlist</a>

















        
        <a href="write_review.php?product_id=<?= $product['product_id'] ?>" class="product-btn">Write a Review</a>

    </div>

</div>


<div class="product-reviews">

    <h2>Customer Reviews</h2>

    <?php if (count($reviews) > 0): ?>

        <?php foreach ($reviews as $review): ?>

            <div class="review-box">

                <div class="review-rating">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <?= $i <= $review['rating'] ? "⭐" : "☆" ?>
                    <?php endfor; ?>
                </div>

                <p class="review-text">
                    <?= htmlspecialchars($review['review_text']) ?>
                </p>

                <p class="review-meta">
                    <?= htmlspecialchars($review['reviewer_name']) ?> • 
                    <?= date("d M Y", strtotime($review['review_date'])) ?>
                </p>

            </div>

        <?php endforeach; ?>

    <?php else: ?>

        <p>No reviews for this product yet.</p>

    <?php endif; ?>

</div>

<?php include 'footer.php'; ?>