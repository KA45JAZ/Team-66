<div class="chatbot-container">

    <h1 class="chatbot-title">Chatbot</h1>

    <form method="POST" class="chatbot-form">
        <input type="text" name="message" placeholder="Ask a question..." required class="chatbot-input">
        
        <button type="submit" class="chatbot-button">
            Send
        </button>
    </form>

    <div class="chatbot-response">
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