<?php
session_start();

// Initialize example basket if empty for testing purposes
if(!isset($_SESSION['basket'])) {
    $_SESSION['basket'] = [
        [
            'id' => 1,
            'name' => 'Black T-Shirt',
            'price' => 19.99,
            'quantity' => 2
        ],
        [
            'id' => 2,
            'name' => 'Jeans',
            'price' => 22.50,
            'quantity' => 1
        ]
    ];
}

$basket = $_SESSION['basket'];


if(isset($_POST['remove_id'])){
    $removeId = intval($_POST['remove_id']);
    $newBasket = [];
    foreach($_SESSION['basket'] as $item){
        if($item['id'] !== $removeId){
            $newBasket[] = $item;
        }
    }
    $_SESSION['basket'] = $newBasket;
    $basket = $_SESSION['basket'];
}

// Handle quantity update
if(isset($_POST['update_id'], $_POST['quantity'])){
    $updateId = intval($_POST['update_id']);
    $newQty = intval($_POST['quantity']);
    $newBasket = [];
    foreach($_SESSION['basket'] as $item){
        if($item['id'] === $updateId){
            $item['quantity'] = $newQty;
        }
        $newBasket[] = $item;
    }
    $_SESSION['basket'] = $newBasket;
    $basket = $_SESSION['basket'];
}

$basketEmpty = empty($basket);
?>

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
    <style>
        /* Full viewport */
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
        }

        /* Page content container */
        .basket-page {
            align-items: <?php echo $basketEmpty ? 'center' : 'flex-start'; ?>;
            height: calc(100% - 60px); /* minus navbar height */
        }
    </style>

    <!-- Favicon and Title -->
    <title>GoodFit</title>
    <link rel="icon" href="favicon/GoodFit_favicon.png" type="image/x-icon">
</head>


<body>

    <!-- Header + Navbar Include -->
    <header id="main-header">
        <?php include 'navbar.php'; ?>
    </header>

    <!-- Page content -->
    <div class="basket-page">
    <?php if($basketEmpty): ?>
        <div class="empty-basket">
            <img src="images/emptybasket.png" alt="Empty Basket">
            <p>Your basket is empty!</p>
        </div>
    <?php else: ?>
        <div class="basket-box">
            <h2>Basket</h2>
            <?php foreach($basket as $item): ?>
                <div class="basket-item">
                    <div class="item-left">
                        <span><?php echo htmlspecialchars($item['name']); ?></span>
                        <div class="quantity-price">
                            <!-- Quantity form -->
                            <form method="post">
                                <input type="hidden" name="update_id" value="<?php echo $item['id']; ?>">
                                <select name="quantity" onchange="this.form.submit()">
                                    <?php for($i=1;$i<=10;$i++): ?>
                                        <option value="<?php echo $i; ?>" <?php echo $i==$item['quantity']?'selected':''; ?>><?php echo $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                            </form>
                            <span>£<?php echo number_format($item['price']*$item['quantity'],2); ?></span>
                        </div>
                    </div>

                    <!-- Remove button -->
                    <form method="post">
                        <input type="hidden" name="remove_id" value="<?php echo $item['id']; ?>">
                        <button type="submit" class="remove-btn">&times;</button>
                    </form>
                </div>
            <?php endforeach; ?>

            <div class="basket-footer">
                Total: £
                <?php 
                $total = 0;
                foreach($basket as $item) $total += $item['price'] * $item['quantity'];
                echo number_format($total,2);
                ?>
            </div>
        </div>
    <?php endif; ?>
    </div>

    <?php include 'footer.php'; ?>

</body>
</html>
