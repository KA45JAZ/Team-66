
<?php



// CONF
$adminEmail = 'support@goodfit.com';
$dataDir = __DIR__ . '/data';
$dataFile = $dataDir . '/messages.csv';

// Ensure data directory exists
if (!is_dir($dataDir)) {
    @mkdir($dataDir, 0755, true);
}

// Helper: prevent basic header injection
function hasHeaderInjection($str) {
    return preg_match("/[\r\n]/", $str);
}

$errors = [];
$sent = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';

    if ($name === '') $errors[] = 'Name is required.';
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required.';
    if ($message === '') $errors[] = 'Message cannot be empty.';

    if (hasHeaderInjection($name) || hasHeaderInjection($email)) {
        $errors[] = 'Invalid input.';
    }

    if (empty($errors)) {
        $subject = 'Goodfit Contact Form: ' . substr($name, 0, 50);
        $body = "Name: $name\nEmail: $email\n\nMessage:\n$message\n";
        $headers = "From: $email\r\nReply-To: $email\r\n";

        $mailSuccess = false;
        if (function_exists('mail')) {
            $mailSuccess = @mail($adminEmail, $subject, $body, $headers);
        }

        $fileSuccess = false;
        $row = [date('Y-m-d H:i:s'), $name, $email, $message, $mailSuccess ? 'email_sent' : 'email_failed'];
        if ($fp = @fopen($dataFile, 'a')) {
            fputcsv($fp, $row);
            fclose($fp);
            $fileSuccess = true;
        }

        if ($mailSuccess || $fileSuccess) {
            header('Location: contactus.php?sent=1');
            exit;
        } else {
            $errors[] = 'Failed to submit message (server issue).';
        }
    }
}

if (isset($_GET['sent']) && $_GET['sent'] == '1') {
    $sent = true;
}
?>
<!DOCTYPE html>
<html lang="en">
  
<head>
  <meta charset="utf-8">
  <title>Contact Us - Goodfit</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="contact-container">
  <h1>Contact Us</h1>

<div class="container contact-overview"> <!-- Added contact-wrapper class for specific styling -->
  <h1 class="contact-title">Contact Us</h1>
    <div class="contactusLayout">
      <div class="contactusInfo">
        <p><strong>Opening Hours:</strong><br>
          Monday – Friday: 10am – 7pm<br>
          Saturday & Sunday: 11am – 5pm
        </p>


        <p>
          If you have any queries, contact us at <strong>0778753649</strong> or email
          <strong>support@goodfit.com</strong>. We're always here to help.
        </p>

        <p><strong>Address:</strong><br>
          Goodfit<br>
          16 Hazel Road<br>
          Birmingham<br>
          B4 7ET
        </p>
      </div> <!-- End contactUs page layout-->
    

      <div class ="contactBox"> <!-- Added contact-box class for specific styling -->
        
        <h2 class="sendingMessage">Send Us a Message</h2> <!-- Added send-title class for specific styling -->

        <?php if ($sent): ?>
          <div class="success">Thank you! Your message has been received. We will reply as soon as possible.</div>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
          <div class="error">
            <?php foreach ($errors as $e) echo '<p>' . htmlspecialchars($e) . '</p>'; ?>
          </div>
        <?php endif; ?>

        <form action="contactus.php" method="POST" class="contact-form" novalidate>
          <label for="name">Name:</label>
          <input id="name" type="text" name="name" required value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>">

          <label for="email">Email:</label>
          <input id="email" type="email" name="email" required value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">

          <label for="message">Message:</label>
          <textarea id="message" name="message" rows="5" required><?php echo isset($message) ? htmlspecialchars($message) : ''; ?></textarea>

          <button type="submit">Send Message</button>
        </form>
      </div> <!-- End contactus page Box -->
    </div>
    
</div>

<?php include 'footer.php'; ?>

  
</body>
</html>