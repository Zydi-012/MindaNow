<?php
require_once '../../includes/auth.php';
require_once '../../includes/db.php';

$result = $conn->query("SELECT * FROM announcements ORDER BY created_at DESC");
?>

<?php include '../../includes/header.php'; ?>

<div class="container py-5">

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-semibold">Articles</h3>

    <div>
        <a href="/Mindanow/admin/dashboard.php" class="btn btn-dark btn-sm">
            Return to Dashboard
        </a>

        <a href="create.php" class="btn btn-dark btn-sm">
            Add New
        </a>
    </div>
</div>

<table class="table table-bordered">

<thead>
<tr>
<th>#</th>
<th>Title</th>
<th>Date</th>
<th>Actions</th>
</tr>
</thead>

<tbody>

<?php $i=1; while($row=$result->fetch_assoc()): ?>

<tr>
<td><?php echo $i++; ?></td>
<td><?php echo htmlspecialchars($row['title']); ?></td>
<td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>

<td>
<a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
<a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger">Delete</a>
</td>

</tr>

<?php endwhile; ?>

</tbody>

</table>

</div>

<?php include '../../includes/footer.php'; ?>