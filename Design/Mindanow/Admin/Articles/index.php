<?php
require_once '../../includes/auth.php';
require_once '../../includes/db.php';

// Fetch all articles
$result = $conn->query("SELECT * FROM articles ORDER BY created_at DESC");
?>

<?php include '../../includes/header.php'; ?>

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-semibold">Articles</h3>
        <div>
            <!-- Dashboard Button -->
            <a href="/Mindanow/admin/dashboard.php" class="btn btn-outline-secondary btn-sm me-2">
                Dashboard
            </a>
            <!-- Add New Article Button -->
            <a href="/Mindanow/admin/articles/create.php" class="btn btn-dark btn-sm">
                Add New
            </a>
        </div>
    </div>

    <?php if ($result->num_rows > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Date Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $count = 1; while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $count++; ?></td>
                            <td><?php echo htmlspecialchars($row['title']); ?></td>
                            <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                            <td>
                                <a href="/Mindanow/admin/articles/edit.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                                <a href="/Mindanow/admin/articles/delete.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this article?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="text-muted">No articles found. <a href="/Mindanow/admin/articles/create.php">Add a new article</a>.</p>
    <?php endif; ?>

</div>

<?php include '../../includes/footer.php'; ?>