<?php
require_once '../../includes/auth.php';
require_once '../../includes/db.php';

$id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT * FROM cuisines WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$cuisine = $stmt->get_result()->fetch_assoc();

if(!$cuisine){
    header("Location: index.php");
    exit();
}

// Fetch existing images
$images_stmt = $conn->prepare("SELECT * FROM cuisine_images WHERE cuisine_id=?");
$images_stmt->bind_param("i", $id);
$images_stmt->execute();
$images_result = $images_stmt->get_result();
$images = $images_result->fetch_all(MYSQLI_ASSOC);

if($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = trim($_POST['title']);
    $description = trim($_POST['description']);

    $update = $conn->prepare("UPDATE cuisines SET title=?, description=? WHERE id=?");
    $update->bind_param("ssi", $title, $description, $id);
    $update->execute();

    // Handle image uploads
    if(!empty($_FILES['cuisine_images']['name'][0])){

        $allowed = ['jpg','jpeg','png','gif'];

        foreach($_FILES['cuisine_images']['name'] as $key => $name){

            $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
            if(!in_array($ext, $allowed)) continue;

            $tmp = $_FILES['cuisine_images']['tmp_name'][$key];

            $filename = time().'_'.$name;

            move_uploaded_file($tmp, "../../uploads/cuisines/$filename");

            $img_stmt = $conn->prepare("INSERT INTO cuisine_images (cuisine_id, filename) VALUES (?, ?)");

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

<h3 class="fw-semibold mb-4">Edit Cuisine</h3>

<div class="card border-0 shadow-sm">
<div class="card-body">

<form method="POST" enctype="multipart/form-data">

<div class="mb-3">
<label class="form-label">Title</label>
<input type="text" name="title" class="form-control"
value="<?php echo htmlspecialchars($cuisine['title']); ?>" required>
</div>

<div class="mb-3">
<label class="form-label">Description</label>
<textarea name="description" rows="6" class="form-control" required><?php echo htmlspecialchars($cuisine['description']); ?></textarea>
</div>

<div class="mb-3">
<label class="form-label">Add More Images</label>
<input type="file" name="cuisine_images[]" multiple class="form-control" accept="image/*">
</div>

<?php if(!empty($images)): ?>

<div class="mb-3">
<label class="form-label">Existing Images</label>

<div class="d-flex flex-wrap gap-2">

<?php foreach($images as $img): ?>

<div style="position:relative;">

<img src="/Mindanow/uploads/cuisines/<?php echo $img['filename']; ?>"
width="120" class="rounded border">

<a href="delete_image.php?id=<?php echo $img['id']; ?>&cuisine_id=<?php echo $id; ?>"
style="position:absolute;top:0;right:0;"
class="btn btn-sm btn-danger">&times;</a>

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