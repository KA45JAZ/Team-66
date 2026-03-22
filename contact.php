<?php
include 'navbar.php';
?>

<div class="contact-container">

    <h2>Contact Us</h2>
    <p class="contact-sub">We’d love to hear from you. Send us a message below.</p>

    <?php if (isset($_GET['success'])): ?>
        <p class="success-msg">Your message has been sent successfully.</p>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <p class="error-msg"><?php echo htmlspecialchars($_GET['error']); ?></p>
    <?php endif; ?>

    <form action="contact_process.php" method="POST" class="contact-form">

        <label>Your Name</label>
        <input type="text" name="name" 
               value="<?php echo isset($_SESSION['first_name']) ? $_SESSION['first_name'] : ''; ?>" 
               required>

        <label>Your Email</label>
        <input type="email" name="email" 
               value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>" 
               required>

        <label>Subject</label>
        <input type="text" name="subject" required>

        <label>Message</label>
        <textarea name="message" rows="5" required></textarea>

        <button type="submit" class="contact-btn">Send Message</button>

    </form>

    <div class="contact-details">
        <h3>Opening Hours</h3>
        <p>
            Monday – Friday: 10am – 7pm<br>
            Saturday & Sunday: 11am – 5pm
        </p>

        <h3>Contact Info</h3>
        <p>
            Phone: 0778753649<br>
            Email: <a href="mailto:support@goodfit.com">support@goodfit.com</a><br>
            We're always here to help.
        </p>

        <h3>Address</h3>
        <p>
            Goodfit<br>
            16 Hazel Road<br>
            Birmingham<br>
            B4 7ET
        </p>
    </div>

</div>
<?php include 'chatbot-overlay.php'; ?>

<?php include 'footer.php'; ?>