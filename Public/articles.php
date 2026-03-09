<?php
session_start();
require_once '../Includes/db.php';

$id = intval($_GET['id'] ?? 0);

if ($id <= 0) {
    header("Location: index.php");
    exit();
}

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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo htmlspecialchars($article['title']); ?> - MindaNow</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2563eb;
            --accent-color: #f59e0b;
        }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .navbar-brand { 
            font-weight: 700; 
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .article-title { font-size: 2rem; font-weight: 700; line-height: 1.3; }
        .article-content { font-size: 1.1rem; line-height: 1.8; }
        .back-link { color: var(--primary-color); text-decoration: none; font-weight: 600; }
        .back-link:hover { color: #1e40af; }
    </style>
</head>
<body class="bg-light">

    <nav class="navbar navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand fs-4" href="index.php">
                <i class="fas fa-brain"></i> MindaNow
            </a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="../Admin/dashboard.php" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            <?php endif; ?>
        </div>
    </nav>

    <div class="container py-5">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4 p-md-5">
                <a href="index.php" class="back-link d-inline-flex align-items-center gap-2 mb-4">
                    <i class="fas fa-arrow-left"></i> Back to Articles
                </a>

                <h1 class="article-title mb-3">
                    <?php echo htmlspecialchars($article['title']); ?>
                </h1>

                <p class="text-muted mb-4">
                    <i class="far fa-calendar"></i>
                    <?php echo date('F d, Y', strtotime($article['created_at'])); ?>
                </p>

                <div class="article-content">
                    <?php echo nl2br(htmlspecialchars($article['content'])); ?>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-white text-center py-3 mt-5 border-top">
        <small class="text-muted">&copy; <?php echo date('Y'); ?> MindaNow. All rights reserved.</small>
    </footer>

</body>
</html>