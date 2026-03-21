<?php include 'navbar.php'; ?>

<div style="padding: 50px 20px; max-width: 700px; margin: auto;">

    <h1 style="text-align:center; color:#4a6cf7;">Chatbot</h1>

    <form method="POST" style="margin-top:30px; display:flex; gap:10px;">
        <input type="text" name="message" placeholder="Ask a question..." required 
        style="flex:1; padding:10px; border-radius:8px; border:1px solid #ccc;">
        
        <button type="submit" 
        style="padding:10px 20px; background:#4a6cf7; color:white; border:none; border-radius:8px;">
        Send
        </button>
    </form>

    <div style="margin-top:30px; padding:20px; background:#f9f9f9; border-radius:10px;">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $msg = strtolower($_POST['message']);

            if (strpos($msg, "order") !== false) {
                echo "<p><strong>Bot:</strong> You can view your orders in your account section.</p>";
            } 
            elseif (strpos($msg, "return") !== false) {
                echo "<p><strong>Bot:</strong> Returns are allowed within 14 days.</p>";
            } 
            elseif (strpos($msg, "account") !== false) {
                echo "<p><strong>Bot:</strong> You can manage your account after logging in.</p>";
            } 
            elseif (strpos($msg, "contact") !== false) {
                echo "<p><strong>Bot:</strong> You can contact us via the Contact Us page.</p>";
            } 
            else {
                echo "<p><strong>Bot:</strong> Sorry, I don’t understand. Try asking about orders, returns, or accounts.</p>";
            }
        }
        ?>
    </div>

</div>

<?php include 'footer.php'; ?>