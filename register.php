<?php include 'navbar.php'; ?>
<?php include 'connectdb.php'; ?>
<!DOCTYPE html>
<html lang="en">

<?php include 'head.php'; ?>
<div class="register-container">

    <h2>Create Your Account</h2>

    <?php if (isset($_GET['error'])): ?>
        <p class="error-msg"><?php echo htmlspecialchars($_GET['error']); ?></p>
    <?php endif; ?>

    <form action="register_process.php" method="POST" class="register-form">

        <label>First Name</label>
        <input type="text" name="first_name" required>

        <label>Last Name</label>
        <input type="text" name="last_name" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Phone</label>
        <input type="text" name="phone" pattern="[0-9]{0,11}" maxlength="11">

        <label>Password</label>
        <input type="password" name="password" required>

        <label>Confirm Password</label>
        <input type="password" name="confirm_password" required>
        <p class="password-rules">
            Password must be minimum 8 characters long, include 1 uppercase letter,
            one lower case letter, 1 number and 1 special character.
        </p>
        <label>Role</label>
        <select name="role">
            <option value="customer">Customer</option>
            <option value="admin">Admin</option>
        </select>

        <button type="submit" class="register-btn">Register</button>
        <p class="already-user">
        Already a user? <a href="login.php">Log in</a>
    </p>

    </form>

</div>

<?php include 'footer.php'; ?>