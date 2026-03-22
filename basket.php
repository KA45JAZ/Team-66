<?php
session_start();
include 'navbar.php';
include 'connectdb.php';

// Basket exists?
$basket = isset($_SESSION['basket']) ? $_SESSION['basket'] : [];
?>

<div class="basket-container">

    <h1 class="basket-title">Your Basket</h1>

    <?php if (empty($basket)): ?>
        <p class="empty-basket">Your basket is empty.</p>
    <?php else: ?>

        <table class="basket-table">
            <tr>
                <th>Product</th>
                <th>Name</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Subtotal</th>
                <th></th>
            </tr>

            <?php
            $total = 0;
            foreach ($basket as $item):
                $subtotal = $item['price'] * $item['quantity'];
                $total += $subtotal;
            ?>
            <tr>
                <td><img src="<?= $item['image'] ?>" class="basket-img"></td>

                <td><?= $item['name'] ?></td>

                <td>£<?= number_format($item['price'], 2) ?></td>

                <td>
                    <form action="update_basket.php" method="POST" class="qty-form">
                        <input type="hidden" name="id" value="<?= $item['id'] ?>">
                        <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1" class="qty-input">
                        <button type="submit" class="qty-btn">Update</button>
                    </form>
                </td>

                <td>£<?= number_format($subtotal, 2) ?></td>

                <td>
                    <a href="remove_from_basket.php?id=<?= $item['id'] ?>" class="remove-btn">Remove</a>
                </td>
            </tr>
            <?php endforeach; ?>

        </table>

        <div class="basket-total">
            <h2>Total: £<?= number_format($total, 2) ?></h2>
            <a href="checkout.php" class="checkout-btn">Proceed to Checkout</a>
        </div>

    <?php endif; ?>

</div>

<?php include 'footer.php'; ?>