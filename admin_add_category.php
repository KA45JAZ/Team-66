<?php
require 'navbar.php';
require 'admin_check.php';
require 'connectdb.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = $_POST['category_name'];
    $description = $_POST['description'];

    $stmt = $db->prepare("
        INSERT INTO categories (category_name, description)
        VALUES (:name, :description)
    ");

    $stmt->execute([
        ':name' => $name,
        ':description' => $description
    ]);

    header("Location: admin_categories.php?success=Category added");
    exit;
}
?>

<div class="admin-container">
    <h1 class="admin-title">Add Category</h1>

    <form method="POST" class="admin-form">
        <label>Name</label>
        <input type="text" name="category_name" required>

        <label>Description</label>
        <textarea name="description" required></textarea>

        <button type="submit" class="admin-btn add-btn">Add Category</button>
    </form>
</div>

<?php require 'footer.php'; ?>