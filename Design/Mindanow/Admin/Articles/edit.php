<?php
require_once '../../includes/auth.php';
require_once '../../includes/db.php';

$id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT * FROM articles WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$article = $result->fetch_assoc();

if (!$article) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    $update = $conn->prepare("UPDATE articles SET title=?, content=? WHERE id=?");
    $update->bind_param("ssi", $title, $content, $id);
    $update->execute();

    header("Location: index.php");
    exit();
}
?>

<?php include '../../includes/header.php'; ?>

<div class="container py-5">

    <h3 class="fw-semibold mb-4">Edit Article</h3>

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <form method="POST">

                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" 
                           class="form-control"
                           value="<?php echo htmlspecialchars($article['title']); ?>" 
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Content</label>
                    <textarea name="content" rows="6" class="form-control" required><?php 
                        echo htmlspecialchars($article['content']); 
                    ?></textarea>
                </div>

                <button type="submit" class="btn btn-dark btn-sm">Update</button>
                <a href="index.php" class="btn btn-outline-secondary btn-sm">Cancel</a>

            </form>

        </div>
    </div>

</div>

<?php include '../../includes/footer.php'; ?>