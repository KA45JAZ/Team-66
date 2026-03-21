<?php
session_start();

include 'connectdb.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $db->prepare("
    SELECT role 
    FROM users 
    WHERE user_id = :id
");

$stmt->execute([
    'id' => $user_id
]);

$user = $stmt->fetch();

if ($user['role'] === 'admin') {

    header("Location: admin_dashboard.php");
    exit();

} else {

    header("Location: customer_dashboard.php");
    exit();

}
?>