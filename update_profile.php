<?php
include 'auth_check.php';
include 'connectdb.php';
include 'navbar.php';


$user_id = $_SESSION['user_id'];


$message = "";


$stmt = $db->prepare("SELECT first_name, last_name, email, phone FROM users WHERE user_id = :id");
$stmt->execute(['id' => $user_id]);
$user = $stmt->fetch();


if (isset($_POST['update'])) {

    
    $first = $_POST['first_name'];
    $last = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

  
    $update_stmt = $db->prepare("
        UPDATE users 
        SET first_name = :first, last_name = :last, email = :email, phone = :phone
        WHERE user_id = :id
    ");

    $update_stmt->execute([
        'first' => $first,
        'last' => $last,
        'email' => $email,
        'phone' => $phone,
        'id' => $user_id
    ]);

    $message = "Profile updated successfully";

   
    $stmt->execute(['id' => $user_id]);
    $user = $stmt->fetch();
}

/* ------------------ DELETE ACCOUNT ------------------ */
if (isset($_POST['delete'])) {

    // Delete user from database
    $delete_stmt = $db->prepare("DELETE FROM users WHERE user_id = :id");
    $delete_stmt->execute(['id' => $user_id]);

   
    session_destroy();

   
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<?php include 'head.php'; ?>
<div class="dashboard-container">

    <!-- Header -->
    <div class="dashboard-header">
        <h1>Edit Profile</h1>
        <p>Update your personal details</p>
    </div>

    <div class="dashboard-layout">

        <!-- Sidebar -->
        <div class="dashboard-sidebar">
            <a href="customer_dashboard.php">Dashboard</a>
            <a href="profile.php">Profile</a>
            <a href="orders.php">Orders</a>
            <a href="wishlist.php">Wishlist</a>
            <a href="basket.php">Basket</a>
            <a href="password_change.php">Change Password</a>
            <a href="logout.php" class="profile-btn delete-btn">Logout</a>
        </div>

        <!-- Main Content -->
        <div class="dashboard-main">

            <div class="dashboard-card">

                <h2>Update Your Details</h2>

                
                <?php if ($message): ?>
                    <p class="success-msg"><?= $message ?></p>
                <?php endif; ?>

                
                <form method="POST">

                    <label>First Name</label>
                    <input type="text" name="first_name" value="<?= htmlspecialchars($user['first_name']) ?>" required>

                    <label>Last Name</label>
                    <input type="text" name="last_name" value="<?= htmlspecialchars($user['last_name']) ?>" required>

                    <label>Email</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

                    <label>Phone</label>
                    <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>">

                    <button type="submit" name="update" class="profile-btn">
                        Save Changes
                    </button>

                </form>

            </div>

            <!-- Delete Account -->
            <div class="dashboard-card">

                <h2>Delete your Account</h2>
                <p>Deleting your account is permanent and cannot be undone.</p>

                <form method="POST">
                    <button type="submit" name="delete" class="profile-btn delete-btn"
                        onclick="return confirm('Are you sure you want to delete your account?');">
                        Delete Account
                    </button>
                </form>

            </div>

        </div>
    </div>
</div>

<?php include 'footer.php'; ?>