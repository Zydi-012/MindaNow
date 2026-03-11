<?php
require_once '../../includes/auth.php';
require_once '../../includes/db.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if (!empty($title) && !empty($content)) {

        // Insert article
        $stmt = $conn->prepare("INSERT INTO articles (title, content) VALUES (?, ?)");
        $stmt->bind_param("ss", $title, $content);
        $stmt->execute();
        $article_id = $stmt->insert_id;

        // Handle image uploads
        if(!empty($_FILES['header_images']['name'][0])){
            $allowed = ['jpg','jpeg','png','gif'];

            foreach($_FILES['header_images']['name'] as $key => $name){
                $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                if(!in_array($ext, $allowed)) continue; // skip invalid files

                $tmp = $_FILES['header_images']['tmp_name'][$key];
                $filename = time().'_'.$name;
                move_uploaded_file($tmp, "../../uploads/articles/$filename");

                $img_stmt = $conn->prepare("INSERT INTO article_images (article_id, filename) VALUES (?, ?)");
                $img_stmt->bind_param("is", $article_id, $filename);
                $img_stmt->execute();
            }
        }

        header("Location: /Mindanow/admin/articles/index.php");
        exit();

    } else {
        $error = "Both Title and Content are required.";
    }
}
?>

<?php include '../../includes/header.php'; ?>

<div class="container py-5">

<h3 class="fw-semibold mb-4">Add Article</h3>

<div class="card border-0 shadow-sm">
<div class="card-body">

<?php if (!empty($error)): ?>
    <div class="alert alert-danger small"><?php echo $error; ?></div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">

    <div class="mb-3">
        <label class="form-label">Title</label>
        <input type="text" name="title" class="form-control" placeholder="Enter article title" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Content</label>
        <textarea name="content" rows="6" class="form-control" placeholder="Enter article content" required></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Header Images (Gallery)</label>
        <input type="file" name="header_images[]" multiple class="form-control" accept="image/*">
    </div>

    <button type="submit" class="btn btn-dark btn-sm">Save</button>
    <a href="/Mindanow/admin/articles/index.php" class="btn btn-outline-secondary btn-sm">Cancel</a>

</form>
</div>
</div>
</div>

<?php include '../../includes/footer.php'; ?>