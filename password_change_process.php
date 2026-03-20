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

    if(strlen($new)<8){
        header("Location: password_change.php?error=Password must be at least 8 characters long.");
        exit;
    }

    if(!preg_match('/[A-Z]/', $new)){
        header("Location: password_change.php?error=Password must contain at least one capital/uppercase letter.");
        exit;
    }

    if(!preg_match('/[a-z]/', $new)){
        header("Location: password_changing.php?error=Password must contain at least one small.lowercase letter.");
        exit;
    }

    if(!preg_match('/[0-9]/', $new)){
        header("Location: password_change.php?error=Password must contain at least one number.");
        exit;
    }

    if(!preg_match('/[^A-Za-z0-9]/', $new)){
        header("Location:password_change.php?=Password must contain at least one special character.");
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