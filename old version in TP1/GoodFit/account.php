<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Connect to database
require_once "connectdb.php";


$user_id = $_SESSION['user_id'];
$query = $db->prepare("SELECT first_name, last_name, email FROM users WHERE user_id = ?");
$query->execute([$user_id]);
$user = $query->fetch(PDO::FETCH_ASSOC);


if (!$user) {
    session_destroy();
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account</title>

    
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<?php include "navbar.php"; ?>

<div class="account-container">
    <h2>Welcome, <?php echo htmlspecialchars($user['first_name']); ?>!</h2>

    <p><strong>Name:</strong>
        <?php echo htmlspecialchars($user['first_name'] . " " . $user['last_name']); ?>
    </p>

    <p><strong>Email:</strong>
        <?php echo htmlspecialchars($user['email']); ?>
    </p>

    <a href="basket.php" class="btn">View Basket</a>
    <a href="logout.php" class="btn">Logout</a>
</div>

<?php include "footer.php"; ?>

</body>
</html>