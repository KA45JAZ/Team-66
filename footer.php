<footer class="footer">

    <div class="footer-logo">
        <a href="index.php" class="nav-logo"></a>
    </div>

    <hr class="footer-line">

    <div class="footer-links">
        <a href="aboutus.php">About Us</a>
        <a href="terms.php">Terms & Conditions</a>
        <a href="faq.php">FAQ</a>
        <a href="contact.php">Contact Us</a>
    </div>

    <div class="footer-bottom">
        <p>&copy; <?php echo date('Y'); ?> GoodFit. All rights reserved.</p>
    </div>

</footer>

<!-- Theme Switcher Script -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const themeLink = document.getElementById("theme-style");
    const toggleBtn = document.getElementById("theme-toggle");

    // Load saved theme
    const savedTheme = localStorage.getItem("theme");
    if (savedTheme) {
        themeLink.href = savedTheme;
    }

    // Toggle theme on button click
    toggleBtn.addEventListener("click", () => {
        const current = themeLink.getAttribute("href");

        if (current === "css/light.css") {
            themeLink.href = "css/dark.css";
            localStorage.setItem("theme", "css/dark.css");
        } else {
            themeLink.href = "css/light.css";
            localStorage.setItem("theme", "css/light.css");
        }
    });
});
</script>