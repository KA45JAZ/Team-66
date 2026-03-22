<!-- Floating Chatbot Button -->
<div id="chatbot-toggle"
     style="position: fixed; bottom: 20px; right: 20px; width: 60px; height: 60px;
            background:#4a6cf7; border-radius: 50%; display:flex; justify-content:center;
            align-items:center; cursor:pointer; box-shadow:0 4px 10px rgba(0,0,0,0.3);
            z-index: 9999;">
    <img src="images/chat.png" style="width:30px;">
</div>

<!-- Chatbot Overlay -->
<div id="chatbot-overlay" 
     style="display: <?php echo $chatOpen ? 'block' : 'none'; ?>;
            position: fixed; bottom: 100px; right: 20px; width: 350px;
            box-shadow:0 4px 20px rgba(0,0,0,0.3); z-index:9999;">
    <?php include 'chatbot.php'; ?>

</div>
<?php
$chatOpen = ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['message']));
?>
<script>
document.getElementById("chatbot-toggle").onclick = function() {
    const box = document.getElementById("chatbot-overlay");
    box.style.display = (box.style.display === "none" || box.style.display === "") 
                        ? "block" : "none";
};
</script>