<?php
    session_start();
    include 'navbar.php';
    include 'connectdb.php';

    if(!isset($_SESSION['user_id'])){
        die("<div class=error-page'>You must be logged in to view Account Settings.</div>");
    }

    $user_id = $_SESSION['user_id'];
    $error = "";

    if($_SERVER["REQUEST_METHOD"]==="POST" && isset($_POST['delete_account'])){
        $delete = $db->prepare("
            UPDATE users
            SET first_name = 'Deleted',
                last_name = 'User',
                email = CONCAT('deleted_', user_id, '@deleted.com'),
                phone = NULL,
                isDeleted = 1
            WHERE user_id = :user_id
        ");

        if($delete->execute(['user_id' => $user_id])){
            session_destroy();
            header("Location: register.php");
            exit;
        } else{
            $error = "Account deletion failed. Please try again.";
        }
    }
?>

<div class="account-page">
    <h1>Account Settings</h1>
    <?php if(!empty($error)): ?>
        <p class="error-msg"> <?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <div class="account-section">
        <h2>Security</h2>
        <p>You can change your Password
        <a href="password_change.php" class="account.btn">here</a></p>
    </div>

    <div class="account-section">
        <h2>Privacy Settings</h2>
        <p>Privacy settings can be managed here in future version of the system.</p>
    </div>

    <div class="account-section">
        <h2>Delete Account</h2>
        <p>Deleting your account will deactivate it and remove your personal details.</p>
        <p>Proceed with caution!!!</p>

        <form method="POST" onsubmit="return confirm('Are you sure you want to delete your account?');">
            <button type="submit" name="delete_account" class="delete-btn">Delete Account</button>
        </form>
    </div>

    <p><a href="account.php">Back to Account</a></p>

<?php include 'footer.php'; ?>