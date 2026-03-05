<?php
session_start();
include 'connectdb.php';

// Must be logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Basket must exist
if (!isset($_SESSION['basket']) || empty($_SESSION['basket'])) {
    header("Location: basket.php");
    exit;
}

$basket = $_SESSION['basket'];

// Validate form fields
$required = ['fullname', 'address1', 'city', 'postcode', 'phone'];
foreach ($required as $field) {
    if (empty($_POST[$field])) {
        die("Missing required field: " . htmlspecialchars($field));
    }
}

// Collect form data
$user_id = $_SESSION['user_id'];
$fullname = $_POST['fullname'];
$address1 = $_POST['address1'];
$address2 = $_POST['address2'] ?? '';
$city = $_POST['city'];
$postcode = $_POST['postcode'];
$phone = $_POST['phone'];

// Calculate total
$total = 0;
foreach ($basket as $item) {
    $total += $item['price'] * $item['quantity'];
}

try {
    // Begin transaction
    $db->beginTransaction();

    // Insert order
    $order_stmt = $db->prepare("
        INSERT INTO orders (user_id, fullname, address1, address2, city, postcode, phone, total_price, order_date)
        VALUES (:uid, :fn, :a1, :a2, :city, :pc, :phone, :total, NOW())
    ");

    $order_stmt->execute([
        'uid' => $user_id,
        'fn' => $fullname,
        'a1' => $address1,
        'a2' => $address2,
        'city' => $city,
        'pc' => $postcode,
        'phone' => $phone,
        'total' => $total
    ]);

    // Get order ID
    $order_id = $db->lastInsertId();

    // Insert each item
    $item_stmt = $db->prepare("
        INSERT INTO order_items (order_id, product_id, quantity, price)
        VALUES (:oid, :pid, :qty, :price)
    ");

    // Reduce stock
    $stock_stmt = $db->prepare("
        UPDATE products SET stock = stock - :qty WHERE product_id = :pid
    ");

    foreach ($basket as $item) {
        $item_stmt->execute([
            'oid' => $order_id,
            'pid' => $item['id'],
            'qty' => $item['quantity'],
            'price' => $item['price']
        ]);

        $stock_stmt->execute([
            'pid' => $item['id'],
            'qty' => $item['quantity']
        ]);
    }

    // Commit transaction
    $db->commit();

    // Clear basket
    unset($_SESSION['basket']);

    // Redirect to success page
    header("Location: order_success.php?order_id=" . $order_id);
    exit;

} catch (Exception $e) {
    $db->rollBack();
    die("Order failed: " . $e->getMessage());
}
?>