<?php
require_once '../../includes/auth.php';
require_once '../../includes/db.php';

$id=intval($_GET['id']);

$result=$conn->query("SELECT * FROM announcements WHERE id=$id");
$data=$result->fetch_assoc();

if($_SERVER['REQUEST_METHOD']=='POST'){

$title=$_POST['title'];
$content=$_POST['content'];

$stmt=$conn->prepare("UPDATE announcements SET title=?,content=? WHERE id=?");
$stmt->bind_param("ssi",$title,$content,$id);
$stmt->execute();

header("Location:index.php");
exit();
}
?>

<?php include '../../includes/header.php'; ?>

<div class="container py-5">

<h3>Edit Announcement</h3>

<form method="POST">

<div class="mb-3">
<label>Title</label>
<input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($data['title']); ?>">
</div>

<div class="mb-3">
<label>Content</label>
<textarea name="content" rows="6" class="form-control"><?php echo htmlspecialchars($data['content']); ?></textarea>
</div>

<button class="btn btn-dark">Update</button>

</form>

</div>

<?php include '../../includes/footer.php'; ?>