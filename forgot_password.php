<?php
    include 'navbar.php';
    include 'connectdb.php';

    $error = "";
    $success = "";

    if($_SERVER["REQUEST_METHOD"] === "POST"){
        $email = trim($_POST['email']);
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        //Is the user registered and does password meet rules
        $stmt = $db->prepare("SELECT user_id FROM users WHERE email = :email LIMIT 1");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch();

        if(!$user){
            $error = "No account was found with that email address.";
        } elseif($new_password !== $confirm_password){
            $error = "Passwords do not match.";
        } elseif(strlen($new_password) < 8){
            $error = "Password must be at least 8 characters long";
        } elseif(!preg_match('/[A-Z]/', $new_password)){
            $error = "Password must include at least one capital/uppercase letter.";
        } elseif(!preg_match('/[a-z]/', $new_password)){
            $error = "Password must include at least one small/lowercase letter.";
        } elseif(!preg_match('/[0-9]/', $new_password)){
            $error = "Password must include at least one number.";
        } elseif(!preg_match('/[^A-Za-z0-9]/', $new_password)){
            $error = "Password must include at least one speicial character.";
        } else{
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            //update the database
            $update = $db->prepare("
                UPDATE users
                SET password_hash = :password_hash
                WHERE email = :email
            ");

            $update->bindParam(':password_hash', $hashed_password);
            $update->bindParam(':email', $email);

            if($update->execute()){
                $success = "Your password has been reset successfully. You can now log in.";
            } else{
                $error = "Password reset failed. Please try again.";
            }
        }
    }
?>

<div class="login-container">
    <h2>Forgotten Password</h2>

    <?php if(!empty($error)): ?>
        <p class="error-msg"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if(!empty($success)): ?>
        <p class="success-msg"><?= htmlspecialchars($success) ?></p>
        <p><a href="login.php">Go to Login</a></p>
    <?php else: ?>
        <form method="POST" class="login-form">
            <label>Email</label>
            <input type="email" name="email" required>

            <label>New Password</label>
            <input type="password" name="new_password" required>

            <label>Confirm New Password</label>
            <input type="password" name="confirm_password" required>

            <p class="password-rules">
                Password must be at least 8 characters long and include 1 uppercase/capital letter,
                1 lowercase/small letter, 1 number, and 1 special character.
            </p>

            <button type="submit" class="login-btn">Reset Password</button>
        </form>
    <?php endif; ?>
</div>
<?php include 'footer.php'; ?>