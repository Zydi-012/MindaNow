<?php
// ==================== PHP: Handle Form ====================
require_once '../../includes/auth.php';
require_once '../../includes/db.php';

$error = '';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if (!empty($title) && !empty($content)) {

        // Insert into database using prepared statement
        $stmt = $conn->prepare("INSERT INTO articles (title, content) VALUES (?, ?)");
        $stmt->bind_param("ss", $title, $content);
        $stmt->execute();

        // Redirect to articles list (absolute path)
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

            <!-- Error message -->
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger small">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <!-- Article Form -->
            <form method="POST">

                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" placeholder="Enter article title" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Content</label>
                    <textarea name="content" rows="6" class="form-control" placeholder="Enter article content" required></textarea>
                </div>

                <button type="submit" class="btn btn-dark btn-sm">Save</button>

                <!-- Cancel button with absolute path -->
                <a href="/Mindanow/admin/articles/index.php" class="btn btn-outline-secondary btn-sm">
                    Cancel
                </a>

            </form>

        </div>
    </div>

</div>

<?php include '../../includes/footer.php'; ?>