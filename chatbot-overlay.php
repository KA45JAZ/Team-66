<?php
// Determine if chat should be open after a POST (message sent)
$chatOpen = ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['message']));
?>

<!-- Floating Chatbot Button -->
<div id="chatbot-toggle">
    <img src="images/chat.png" alt="Chatbot">
</div>

<!-- Chatbot Overlay -->
<div id="chatbot-overlay" class="<?= $chatOpen ? 'open' : '' ?>">
    <?php include 'chatbot.php'; ?>
</div>

<style>
#chatbot-toggle {
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: 60px;
    height: 60px;
    background: #4a6cf7;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    box-shadow: 0 4px 10px rgba(0,0,0,0.3);
    z-index: 9999;
}

#chatbot-toggle img {
    width: 30px;
}

#chatbot-overlay {
    display: none;
    position: fixed;
    bottom: 100px;
    right: 20px;
    width: 350px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.3);
    z-index: 9999;
}

/* When open */
#chatbot-overlay.open {
    display: block;
}
</style>

<script>
const toggle = document.getElementById("chatbot-toggle");
const overlay = document.getElementById("chatbot-overlay");

toggle.addEventListener("click", () => {
    overlay.classList.toggle("open");
});
</script>