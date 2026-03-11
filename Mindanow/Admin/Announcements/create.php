<?php
require_once '../../includes/auth.php';
require_once '../../includes/db.php';

if($_SERVER['REQUEST_METHOD']=='POST'){

$title=$_POST['title'];
$content=$_POST['content'];

$stmt=$conn->prepare("INSERT INTO announcements (title,content) VALUES (?,?)");
$stmt->bind_param("ss",$title,$content);
$stmt->execute();

header("Location:index.php");
exit();
}
?>

<?php include '../../includes/header.php'; ?>

<div class="container py-5">

<h3>Create Announcement</h3>

<form method="POST">

<div class="mb-3">
<label>Title</label>
<input type="text" name="title" class="form-control" required>
</div>

<div class="mb-3">
<label>Content</label>
<textarea name="content" rows="6" class="form-control" required></textarea>
</div>

<button class="btn btn-dark">Save</button>

</form>

</div>

<?php include '../../includes/footer.php'; ?>