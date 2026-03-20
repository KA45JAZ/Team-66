<?php
require 'navbar.php';
require 'admin_check.php';
require 'connectdb.php';

if (!isset($_GET['id'])) {
    header("Location: admin_categories.php?error=No category selected");
    exit;
}

$id = $_GET['id'];

$stmt = $db->prepare("SELECT * FROM categories WHERE category_id = :id");
$stmt->execute([':id' => $id]);
$category = $stmt->fetch();

if (!$category) {
    header("Location: admin_categories.php?error=Category not found");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = $_POST['category_name'];
    $description = $_POST['description'];

    $update = $db->prepare("
        UPDATE categories
        SET category_name = :name, description = :description
        WHERE category_id = :id
    ");

    $update->execute([
        ':name' => $name,
        ':description' => $description,
        ':id' => $id
    ]);

    header("Location: admin_categories.php?success=Category updated");
    exit;
}
?>

<div class="admin-container">
    <h1 class="admin-title">Edit Category</h1>

    <form method="POST" class="admin-form">
        <label>Name</label>
        <input type="text" name="category_name" value="<?= htmlspecialchars($category['category_name']) ?>" required>

        <label>Description</label>
        <textarea name="description" required><?= htmlspecialchars($category['description']) ?></textarea>

        <button type="submit" class="admin-btn edit-btn">Save Changes</button>
    </form>
</div>

<?php require 'footer.php'; ?>