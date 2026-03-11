<?php
require_once '../../includes/auth.php';
require_once '../../includes/db.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = trim($_POST['title']);
    $description = trim($_POST['description']);

    if (!empty($title) && !empty($description)) {

        // Insert cuisine
        $stmt = $conn->prepare("INSERT INTO cuisines (title, description) VALUES (?, ?)");
        $stmt->bind_param("ss", $title, $description);
        $stmt->execute();
        $cuisine_id = $stmt->insert_id;

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
                $img_stmt->bind_param("is", $cuisine_id, $filename);
                $img_stmt->execute();
            }
        }

        header("Location: /Mindanow/admin/cuisines/index.php");
        exit();

    } else {

        $error = "Both Title and Description are required.";

    }
}
?>

<?php include '../../includes/header.php'; ?>

<div class="container py-5">

<h3 class="fw-semibold mb-4">Add Cuisine</h3>

<div class="card border-0 shadow-sm">
<div class="card-body">

<?php if (!empty($error)): ?>
<div class="alert alert-danger small"><?php echo $error; ?></div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">

<div class="mb-3">
<label class="form-label">Title</label>
<input type="text" name="title" class="form-control" placeholder="Enter cuisine name" required>
</div>

<div class="mb-3">
<label class="form-label">Description</label>
<textarea name="description" rows="6" class="form-control" placeholder="Enter cuisine description" required></textarea>
</div>

<div class="mb-3">
<label class="form-label">Cuisine Images (Gallery)</label>
<input type="file" name="cuisine_images[]" multiple class="form-control" accept="image/*">
</div>

<button type="submit" class="btn btn-dark btn-sm">Save</button>

<a href="/Mindanow/admin/cuisines/index.php" class="btn btn-outline-secondary btn-sm">Cancel</a>

</form>

</div>
</div>
</div>

<?php include '../../includes/footer.php'; ?>