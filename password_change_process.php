<?php
session_start();
include 'connectdb.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $user_id = $_SESSION['user_id'];
    $current = $_POST['current_password'];
    $new = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];

    if ($new !== $confirm) {
        header("Location: password_change.php?error=New passwords do not match");
        exit;
    }

    $stmt = $db->prepare("SELECT password_hash FROM users WHERE user_id = :id LIMIT 1");
    $stmt->bindParam(':id', $user_id);
    $stmt->execute();
    $user = $stmt->fetch();

    if (!$user || !password_verify($current, $user['password_hash'])) {
        header("Location: password_change.php?error=Incorrect current password");
        exit;
    }

    $new_hash = password_hash($new, PASSWORD_DEFAULT);

    $update = $db->prepare("UPDATE users SET password_hash = :new WHERE user_id = :id");
    $update->bindParam(':new', $new_hash);
    $update->bindParam(':id', $user_id);

    if ($update->execute()) {
        header("Location: password_change.php?success=1");
        exit;
    } else {
        header("Location: password_change.php?error=Failed to update password");
        exit;
    }
}
?>