<?php
require_once '../../includes/auth.php';
require_once '../../includes/db.php';

$id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT * FROM articles WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$article = $stmt->get_result()->fetch_assoc();

if(!$article){
    header("Location: index.php");
    exit();
}

// Fetch existing images
$images_stmt = $conn->prepare("SELECT * FROM article_images WHERE article_id=?");
$images_stmt->bind_param("i", $id);
$images_stmt->execute();
$images_result = $images_stmt->get_result();
$images = $images_result->fetch_all(MYSQLI_ASSOC);

if($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    $update = $conn->prepare("UPDATE articles SET title=?, content=? WHERE id=?");
    $update->bind_param("ssi", $title, $content, $id);
    $update->execute();

    // Handle new image uploads
    if(!empty($_FILES['header_images']['name'][0])){
        $allowed = ['jpg','jpeg','png','gif'];

        foreach($_FILES['header_images']['name'] as $key => $name){
            $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
            if(!in_array($ext, $allowed)) continue; // skip invalid files

            $tmp = $_FILES['header_images']['tmp_name'][$key];
            $filename = time().'_'.$name;
            move_uploaded_file($tmp, "../../uploads/articles/$filename");

            $img_stmt = $conn->prepare("INSERT INTO article_images (article_id, filename) VALUES (?, ?)");
            $img_stmt->bind_param("is", $id, $filename);
            $img_stmt->execute();
        }
    }

    header("Location: index.php");
    exit();
}
?>

<?php include '../../includes/header.php'; ?>

<div class="container py-5">

<h3 class="fw-semibold mb-4">Edit Article</h3>

<div class="card border-0 shadow-sm">
<div class="card-body">

<form method="POST" enctype="multipart/form-data">

<div class="mb-3">
    <label class="form-label">Title</label>
    <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($article['title']); ?>" required>
</div>

<div class="mb-3">
    <label class="form-label">Content</label>
    <textarea name="content" rows="6" class="form-control" required><?php echo htmlspecialchars($article['content']); ?></textarea>
</div>

<div class="mb-3">
    <label class="form-label">Add More Images</label>
    <input type="file" name="header_images[]" multiple class="form-control" accept="image/*">
</div>

<?php if(!empty($images)): ?>
    <div class="mb-3">
        <label class="form-label">Existing Images</label>
        <div class="d-flex flex-wrap gap-2">
            <?php foreach($images as $img): ?>
                <div style="position:relative;">
                    <img src="/Mindanow/uploads/articles/<?php echo $img['filename']; ?>" width="120" class="rounded border">
                    <a href="delete_image.php?id=<?php echo $img['id']; ?>&article_id=<?php echo $id; ?>" style="position:absolute;top:0;right:0;" class="btn btn-sm btn-danger">&times;</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>

<button type="submit" class="btn btn-dark btn-sm">Update</button>
<a href="index.php" class="btn btn-outline-secondary btn-sm">Cancel</a>

</form>
</div>
</div>
</div>

<?php include '../../includes/footer.php'; ?>