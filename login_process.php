<?php
session_start();
include 'connectdb.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Fetch user by email which is not deleted
    $stmt = $db->prepare("SELECT * FROM users WHERE email = :email AND isDeleted = 0 LIMIT 1");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $user = $stmt->fetch();

    // If user not found
    if (!$user) {
        header("Location: login.php?error=Invalid email or password");
        exit;
    }

    // Verify password
    if (!password_verify($password, $user['password_hash'])) {
        header("Location: login.php?error=Invalid email or password");
        exit;
    }

    // Store user session
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['first_name'] = $user['first_name'];
    $_SESSION['last_name'] = $user['last_name'];
    $_SESSION['role'] = $user['role'];

    // Redirect based on role
    if ($user['role'] === 'admin') {
        header("Location: admin_dashboard.php");
        exit;
    } else {
        header("Location: index.php");
        exit;
    }
}
?>