<?php
require "navbar.php";
require "admin_check.php";
require "connectdb.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["category_name"]);
    $description = $_POST["description"];

    // Check for duplicate category name (case-insensitive)
    $checkStmt = $db->prepare(
        "SELECT COUNT(*) FROM categories WHERE LOWER(category_name) = LOWER(:name)",
    );
    $checkStmt->execute([":name" => $name]);
    $exists = $checkStmt->fetchColumn();

    if ($exists) {
        $error = "A category with this name already exists.";
    } else {
        $stmt = $db->prepare("
                INSERT INTO categories (category_name, description)
                VALUES (:name, :description)
        ");

        $stmt->execute([
            ":name" => $name,
            ":description" => $description,
        ]);

        header("Location: admin_categories.php?success=Category added");
        exit();
    }
}
?>

<div class="admin-container">
    <h1 class="admin-title">Add Category</h1>

    <?php if (!empty($error)): ?>
        <p class="error-msg"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST" class="admin-form">
        <label>Name</label>
        <input type="text" name="category_name" value="<?= htmlspecialchars(
            $name ?? "",
        ) ?>" required>

        <label>Description</label>

        <textarea name="description" required><?= htmlspecialchars(
            $description ?? "",
        ) ?></textarea>

        <button type="submit" class="admin-btn add-btn">Add Category</button>
    </form>
</div>

<?php require "footer.php"; ?>
