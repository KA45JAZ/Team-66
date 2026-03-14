<?php
include 'auth_check.php';
include 'navbar.php';
?>

<div class="change-password-container">

    <h2>Change Password</h2>

    <?php if (isset($_GET['error'])): ?>
        <p class="error-msg"><?php echo htmlspecialchars($_GET['error']); ?></p>
    <?php endif; ?>

    <?php if (isset($_GET['success'])): ?>
        <p class="success-msg">Password updated successfully.</p>
    <?php endif; ?>

    <form action="password_change_process.php" method="POST" class="password-form">

        <label>Current Password</label>
        <input type="password" name="current_password" required>

        <label>New Password</label>
        <input type="password" name="new_password" required>

        <label>Confirm New Password</label>
        <input type="password" name="confirm_password" required>

        <button type="submit" class="password-btn">Update Password</button>

    </form>

</div>

<?php include 'footer.php'; ?>