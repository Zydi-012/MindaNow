<?php
require_once '../includes/db.php';

$result=$conn->query("SELECT * FROM announcements ORDER BY created_at DESC");
?>

<?php include '../includes/header.php'; ?>

<div class="container py-5">

<h2 class="mb-4">Announcements</h2>

<?php while($row=$result->fetch_assoc()): ?>

<div class="mb-4">

<h4><?php echo htmlspecialchars($row['title']); ?></h4>

<p class="text-muted"><?php echo date('M d, Y',strtotime($row['created_at'])); ?></p>

<p><?php echo substr(strip_tags($row['content']),0,200); ?>...</p>

</div>

<hr>

<?php endwhile; ?>

</div>

<?php include '../includes/footer.php'; ?>