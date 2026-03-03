<?php
require_once '../includes/db.php';

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
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($article['title']); ?> - Mindanow</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<nav class="navbar navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">
            Mindanow
        </a>
    </div>
</nav>

<div class="container py-5">

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">

            <h2 class="fw-bold mb-2">
                <?php echo htmlspecialchars($article['title']); ?>
            </h2>

            <p class="text-muted small mb-4">
                <?php echo date('M d, Y', strtotime($article['created_at'])); ?>
            </p>

            <div style="line-height: 1.8;">
                <?php echo nl2br(htmlspecialchars($article['content'])); ?>
            </div>

            <hr class="my-4">

            <a href="index.php" class="text-decoration-none">
                ← Back to Articles
            </a>

        </div>
    </div>

</div>

<footer class="bg-white text-center py-3 mt-5 border-top">
    <small class="text-muted">© <?php echo date('Y'); ?> Mindanow</small>
</footer>

</body>
</html>