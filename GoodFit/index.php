<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Viewport, Fonts, Stylesheet -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <!-- Favicon and Title -->
    <title>GoodFit</title>
    <link rel="icon" href="favicon/GoodFit_favicon.png" type="image/x-icon">
</head>

<body>

    <!-- Header + Navbar Include -->
    <?php include 'navbar.php'; ?>
    


    <!-- HERO SECTION -->
    <header class="hero-section">
        <div class="hero-text">
            <h1>Premium Sportswear</h1>
            <p>Designed for comfort. Built for performance.</p>
            <a class="hero-btn">Shop Now</a>
        </div>

        <div class="hero-image">
            <img src="https://images.unsplash.com/photo-1517836357463-d25dfeac3438" alt="Athlete">
        </div>
    </header>

    <!-- FEATURED PRODUCTS -->
    <section class="featured-section">
        <h2 class="section-title">Featured Products</h2>

        <div class="product-grid">

            <div class="product-card">
                <img src="images/featured1.png" alt="Product">
                <h3>Performance Hoodie</h3>
                <p class="price">£39.99</p>
                <a class="add-to-cart">Add to Cart</a>
            </div>

            <div class="product-card">
                <img src="images/featured2.png" alt="Product">
                <h3>Training Joggers</h3>
                <p class="price">£29.99</p>
                <a class="add-to-cart">Add to Cart</a>
            </div>

            <div class="product-card">
                <img src="images/featured3.png" alt="Product">
                <h3>Breathable T-Shirt</h3>
                <p class="price">£19.99</p>
                <a class="add-to-cart">Add to Cart</a>
            </div>

        </div>
    </section>

<!-- Added to cart message appearing -->
 
 <script>
    const addToCartButtons = document.querySelectorAll('.add-to-cart');

    addToCartButtons.forEach(button => {
        button.addEventListener('click', () => {
            alert('Item has been added to cart - Happy shopping!');
        });
    });
</script>



 <?php include 'footer.php'; ?>


</body>
</html>