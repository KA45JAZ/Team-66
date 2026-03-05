<?php include 'navbar.php'; ?>
<?php include 'connectdb.php'; ?>

<div class="login-container">

    <h2>Login</h2>

    <?php if (isset($_GET['error'])): ?>
        <p class="error-msg"><?php echo htmlspecialchars($_GET['error']); ?></p>
    <?php endif; ?>

    <?php if (isset($_GET['registered'])): ?>
        <p class="success-msg">Account created successfully. Please log in.</p>
    <?php endif; ?>

    <form action="login_process.php" method="POST" class="login-form">

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit" class="login-btn">Login</button>

    </form>

    <p class="register-link">
        Don’t have an account? <a href="register.php">Register here</a>
    </p>

</div>

<?php include 'footer.php'; ?>