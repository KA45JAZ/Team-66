<?php
session_start();
include 'connectdb.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        header("Location: contact.php?error=All fields are required");
        exit;
    }

    $sql = "INSERT INTO contact_messages (user_id, name, email, subject, message)
            VALUES (:user_id, :name, :email, :subject, :message)";

    $stmt = $db->prepare($sql);

    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':subject', $subject);
    $stmt->bindParam(':message', $message);

    if ($stmt->execute()) {
        header("Location: contact.php?success=1");
        exit;
    } else {
        header("Location: contact.php?error=Failed to send message");
        exit;
    }
}
?>