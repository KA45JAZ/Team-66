<?php
session_start();
include 'connectdb.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $first = trim($_POST['first_name']);
    $last = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $role = $_POST['role']; // customer or admin
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email already exists
    $check = $db->prepare("SELECT user_id FROM users WHERE email = :email LIMIT 1");
    $check->bindParam(':email', $email);
    $check->execute();

    if ($check->fetch()) {
        header("Location: register.php?error=Email already registered");
        exit;
    }

    // Insert new user
    $sql = "INSERT INTO users (first_name, last_name, email, password_hash, phone, role)
            VALUES (:first, :last, :email, :password, :phone, :role)";

    $stmt = $db->prepare($sql);

    $stmt->bindParam(':first', $first);
    $stmt->bindParam(':last', $last);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':role', $role);

    if ($stmt->execute()) {
        header("Location: login.php?registered=1");
        exit;
    } else {
        header("Location: register.php?error=Registration failed");
        exit;
    }
}
?>