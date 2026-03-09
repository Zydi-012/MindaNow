<?php
require_once '../../Includes/auth.php';
require_once '../../Includes/db.php';

$result = $conn->query("SELECT * FROM destinations ORDER BY created_at DESC");
?>

<?php include '../../Includes/header.php'; ?>

<div class="top-bar">
    <h4 class="mb-0">Manage Destinations</h4>
    <a href="create.php" class="btn btn-dark btn-sm">
        <i class="fas fa-plus"></i> Add New
    </a>
</div>

<div class="container-fluid">
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Location</th>
                            <th>Category</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td>
                                        <?php if ($row['image']): ?>
                                            <img src="../../<?php echo $row['image']; ?>" style="width:50px;height:50px;object-fit:cover;border-radius:4px;">
                                        <?php else: ?>
                                            <div style="width:50px;height:50px;background:#ddd;border-radius:4px;"></div>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['location']); ?></td>
                                    <td><span class="badge bg-secondary"><?php echo $row['category']; ?></span></td>
                                    <td>
                                        <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                                        <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this destination?')">Delete</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    No destinations yet. <a href="create.php">Add your first destination</a>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include '../../Includes/footer.php'; ?>
