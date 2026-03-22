<?php
require 'navbar.php';
require 'admin_check.php';
require 'connectdb.php';

$stmt = $db->query("SELECT * FROM categories ORDER BY category_id");
$categories = $stmt->fetchAll();
?>

<div class="admin-container">

    <div class="admin-header">
        <h1 class="admin-title">Manage Categories</h1>
        <a href="admin_add_category.php" class="admin-btn add-btn">Add Category</a>
    </div>

    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($categories as $cat): ?>
                <tr>
                    <td><?= $cat['category_id'] ?></td>
                    <td><?= htmlspecialchars($cat['category_name']) ?></td>
                    <td><?= htmlspecialchars($cat['description']) ?></td>
                    <td>
                        <a href="admin_edit_category.php?id=<?= $cat['category_id'] ?>" class="table-btn edit">Edit</a>
                        <a href="admin_delete_category.php?id=<?= $cat['category_id'] ?>" 
                           class="table-btn delete"
                           onclick="return confirm('Delete this category? Products in this category will break!')">
                           Delete
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require 'footer.php'; ?>