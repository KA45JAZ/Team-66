<?php
    session_start();
    include 'navbar.php';
    include 'connectdb.php';

    if(!isset($_SESSION['user_id'])){
        die("<div class='error-page'>You must be logged in to update your account.</div>");
    }

    $user_id = $_SESSION['user_id'];
    $error = "";
    $success = "";

    //Getting current information from DB
    $stmt = $db->prepare("
        SELECT first_name, last_name, email, phone
        FROM users
        WHERE user_id = :user_id
    ");
    $stmt-> execute(['user_id'=> $user_id]);
    $user = $stmt->fetch();

    if(!$user){
        die("<div class='error page'>User not found.</div>");
    }

    if($_SERVER["REQUEST_METHOD"]==="POST"){
        $first_name = trim($_POST['first_name']);
        $last_name = trim($_POST['last_name']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);

        if(!empty($phone) && !preg_match('/^[0-9]{1,11}$/', $phone)){
            $error = "Phone number must be numeric and up to 11 digits.";
        } else{
            $update = $db->prepare("
                UPDATE users
                SET first_name = :first_name,
                    last_name = :last_name,
                    email = :email,
                    phone = :phone
                WHERE user_id = :user_id
            ");

            if($update->execute([
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'phone' => $phone,
                'user_id' => $user_id
            ])){
                $success = "Personal information updated successfully!";

                $stmt = $db->prepare("
                    SELECT first_name, last_name, email, phone
                    FROM users
                    WHERE user_id = :user_id
                ");
                $stmt->execute(['user_id' => $user_id]);
                $user = $stmt->fetch();
            } else{
                $error = "Update failed. Please try again.";
            }
        }
    }
?>

<div class="account-page">
    <h1>Update Personal Information<h1>

    <?php if(!empty($error)): ?>
        <p class="error-msg"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST" class="account-form">
        <label>First Name:</label>
        <input type="text" name="first_name" value="<?= htmlspecialchars($user['first_name']) ?>" required>
        <br><br>

        <label>Last Name:</label>
        <input type="text" name="last_name" value="<?= htmlspecialchars($user['last_name']) ?>" required>
        <br><br>

        <label>Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
        <br><br>

        <label>Phone:</label>
        <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>" required>
        <br><br>

        <button type="submit" class="account-btn">Save Changes</button>
    </form>
    <p><a href="account.php">Back to Account</a></p>
</div>

<?php include 'footer.php'; ?>