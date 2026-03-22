<?php
    session_start();
    include 'navbar.php';
    include 'connectdb.php';

    //Is user loggged in?
    if(!isset($_SESSION['user_id'])){
        die("<div class ='error-page'>You must be logged in to write a review. You can login <a href='login.php'>here</a></div>");
    }
    $user_id = $_SESSION['user_id'];

    //Get product ID
    if(!isset($_GET['product_id']) || !is_numeric($_GET['product_id'])){
        die("<div class= 'error-page'>Product is Invalid, please go back, refresh the page, and try again.</div>");
    }
    $product_id = intval($_GET['product_id']);

    //is the product in the database?
    $product_stmt = $db->prepare("SELECT name FROM products WHERE product_id = :product_id");
    $product_stmt ->execute(['product_id'=> $product_id]);
    $product = $product_stmt->fetch();
    if (!$product){
        die("<div class='error-page'>Product was not found. Please try again.</div>");
    }

    $error = "";
    $success = "";

    //Submission Form
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0;
        $review_text = trim($_POST['review_text']);

        //Validate that the information inserted is correctly inserted
        if($rating < 1 || $rating > 5){
            $error = "Please choose between 1-5. Thank you.";
        } elseif (empty($review_text)){
            $error = "We are happy to hear from you! What is your opinion on the product?";
        } else {
            //insert in database
            $insert = $db->prepare("
            INSERT INTO reviews (product_id, user_id, rating, review_text, review_date)
            VALUES (:product_id, :user_id, :rating, :review_text, NOW())
            ");

            $insert->execute([
                'product_id' => $product_id,
                'user_id' => $user_id,
                'rating' => $rating,
                'review_text' => $review_text
            ]);

            $success = "Review has submitted successfully! Thank you!";
        }
    }
?>

<div class="review-page">
    <h1>Writing a review for: <?= htmlspecialchars($product['name']) ?></h1>

    <?php if(!empty($error)): ?>
    <p class="error-message"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if(!empty($success)): ?>
    <p class="success-message"><?= htmlspecialchars($success) ?></p>
    <p><a href="product.php?id=<?= $product_id ?>"> Back to Product Details</a></p>
    <?php else: ?>
    <form method="POST" class="review-form">
        <label for="rating">Rating: </label>
        <div class="star-rating">
            <span class="star" data-value="1">☆</span>
            <span class="star" data-value="2">☆</span>
            <span class="star" data-value="3">☆</span>
            <span class="star" data-value="4">☆</span>
            <span class="star" data-value="5">☆</span>
        </div> <br><br>
        <input type="hidden" name="rating" id="rating" required>
        <p id="rating-message"></p>
        <label for="review_text"> Your Review: </label> <br><br>
        <textarea name="review_text" id="review_text" rows="6" required></textarea><br><br>
        <button type="submit" class="product-btn"> Submit Review</button>
    </form>
    <?php endif; ?>
</div>

<script>
    const stars = document.querySelectorAll('.star');
    const ratingInput = document.getElementById('rating');
    const ratingMessage = document.getElementById('rating-message');

    stars.forEach(star => {
        star.addEventListener('click', function(){
            const ratingValue = this.getAttribute('data-value');
            ratingInput.value = ratingValue;

            stars.forEach(s =>{
                if(s.getAttribute('data-value') <= ratingValue){
                    s.textContent = '⭐';
                } else{
                    s.textContent = '☆';
                }
            });
        });
    });
</script>

<?php include 'footer.php' ?>
