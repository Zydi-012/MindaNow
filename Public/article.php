<?php
session_start();
require_once __DIR__ . '/../Includes/db.php';

// Get article ID
$article_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($article_id <= 0) {
    header('Location: index.php');
    exit;
}

// Fetch article
$stmt = $conn->prepare("SELECT * FROM articles WHERE id = ?");
$stmt->bind_param("i", $article_id);
$stmt->execute();
$result = $stmt->get_result();
$article = $result->fetch_assoc();

if (!$article) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($article['title']); ?> - MindaNow</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #1e40af;
            --accent-color: #f59e0b;
            --text-dark: #1f2937;
            --text-light: #6b7280;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-dark);
            background-color: #f9fafb;
        }

        .top-bar {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 8px 0;
            font-size: 0.85rem;
        }

        .top-bar a {
            color: white;
            text-decoration: none;
        }

        .main-navbar {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-size: 1.8rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .article-header {
            background: white;
            padding: 3rem 0;
            margin-bottom: 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .article-title {
            font-size: 2.5rem;
            font-weight: 700;
            line-height: 1.3;
            margin-bottom: 1rem;
        }

        .article-meta {
            color: var(--text-light);
            font-size: 0.95rem;
        }

        .article-meta i {
            margin-right: 5px;
        }

        .featured-image {
            width: 100%;
            max-height: 500px;
            object-fit: cover;
            border-radius: 12px;
            margin-bottom: 2rem;
        }

        .article-content {
            background: white;
            padding: 3rem;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            font-size: 1.1rem;
            line-height: 1.8;
        }

        .article-content p {
            margin-bottom: 1.5rem;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            margin-bottom: 2rem;
        }

        .back-btn:hover {
            color: var(--secondary-color);
        }

        .share-section {
            background: #f9fafb;
            padding: 2rem;
            border-radius: 12px;
            margin-top: 3rem;
            text-align: center;
        }

        .share-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            color: white;
            margin: 5px;
            transition: transform 0.2s;
        }

        .share-btn:hover {
            transform: translateY(-2px);
            color: white;
        }

        .share-facebook { background: #1877f2; }
        .share-twitter { background: #1da1f2; }
        .share-linkedin { background: #0077b5; }

        .main-footer {
            background: #1f2937;
            color: white;
            padding: 2rem 0;
            margin-top: 4rem;
        }
    </style>
</head>
<body>

    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-newspaper"></i> Your trusted source for news and articles
                </div>
                <div>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="../Admin/dashboard.php" class="me-3">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                        <a href="../logout.php">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    <?php else: ?>
                        <a href="../login.php">
                            <i class="fas fa-user-shield"></i> Admin Login
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Navbar -->
    <nav class="main-navbar">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-brain"></i> MindaNow
            </a>
        </div>
    </nav>

    <!-- Article Header -->
    <div class="article-header">
        <div class="container">
            <a href="index.php" class="back-btn">
                <i class="fas fa-arrow-left"></i> Back to Articles
            </a>
            
            <h1 class="article-title">
                <?php echo htmlspecialchars($article['title']); ?>
            </h1>
            
            <div class="article-meta">
                <i class="far fa-calendar"></i>
                Published on <?php echo date('F d, Y', strtotime($article['created_at'])); ?>
            </div>
        </div>
    </div>

    <!-- Article Content -->
    <div class="container pb-5">
        <?php if (!empty($article['featured_image'])): ?>
            <img 
                src="<?php echo htmlspecialchars($article['featured_image']); ?>" 
                alt="<?php echo htmlspecialchars($article['title']); ?>" 
                class="featured-image"
            >
        <?php endif; ?>

        <div class="article-content">
            <?php echo nl2br(htmlspecialchars($article['content'])); ?>
        </div>

        <!-- Share Section -->
        <div class="share-section">
            <h5 class="mb-3">Share this article</h5>
            <a href="#" class="share-btn share-facebook">
                <i class="fab fa-facebook-f"></i> Facebook
            </a>
            <a href="#" class="share-btn share-twitter">
                <i class="fab fa-twitter"></i> Twitter
            </a>
            <a href="#" class="share-btn share-linkedin">
                <i class="fab fa-linkedin-in"></i> LinkedIn
            </a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="main-footer">
        <div class="container text-center">
            <p class="mb-0">&copy; <?php echo date('Y'); ?> MindaNow. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
