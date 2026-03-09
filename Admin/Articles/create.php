<?php
// ==================== PHP: Handle Form ====================
require_once '../../includes/auth.php';
require_once '../../includes/db.php';
require_once '../../includes/upload.php';

$error = '';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $featured_image = '';

    // Handle image upload
    if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] === UPLOAD_ERR_OK) {
        $upload = uploadImage($_FILES['featured_image'], 'articles');
        if ($upload['success']) {
            $featured_image = $upload['filename'];
        } else {
            $error = $upload['message'];
        }
    }

    if (empty($error) && !empty($title) && !empty($content)) {

        // Insert into database
        $stmt = $conn->prepare("INSERT INTO articles (title, content, featured_image) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $title, $content, $featured_image);
        $stmt->execute();

        // Redirect to articles list
        header("Location: index.php");
        exit();

    } elseif (empty($error)) {
        $error = "Both Title and Content are required.";
    }
}
?>

<?php include '../../includes/header.php'; ?>

<div class="container py-5">

    <h3 class="fw-semibold mb-4">Add Article</h3>

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <!-- Error message -->
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger small">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <!-- Article Form -->
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
                    <label class="form-label">Featured Image (optional)</label>
                    <input type="file" name="featured_image" class="form-control" accept="image/*">
                    <small class="text-muted">Max 5MB. JPG, PNG, GIF, WEBP</small>
                </div>

                <button type="submit" class="btn btn-dark btn-sm">Save</button>

                <!-- Cancel button with absolute path -->
                <a href="index.php" class="btn btn-outline-secondary btn-sm">
                    Cancel
                </a>

            </form>

        </div>
    </div>

</div>

<?php include '../../includes/footer.php'; ?>