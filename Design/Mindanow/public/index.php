<?php
session_start();
require_once __DIR__ . '/../includes/db.php';

// Fetch articles
$result = $conn->query("SELECT * FROM articles ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mindanow</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<!-- ================= TOP BAR ================= -->
<div class="bg-white border-bottom">
    <div class="container d-flex justify-content-end py-1">

        <?php if (isset($_SESSION['user_id'])): ?>
            
            <a href="../admin/dashboard.php" 
               class="small text-decoration-none me-3">
               Dashboard
            </a>

            <a href="../logout.php" 
               class="small text-decoration-none text-danger">
               Logout
            </a>

        <?php else: ?>

            <a href="../login.php" 
               class="small text-decoration-none text-muted">
               Admin Login
            </a>

        <?php endif; ?>

    </div>
</div>

<!-- ================= MAIN NAVBAR ================= -->
<nav class="navbar navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold fs-4" href="index.php">
            Mindanow
        </a>
    </div>
</nav>

<!-- ================= CONTENT ================= -->
<div class="container py-5">

    <h3 class="fw-semibold mb-4">Latest Articles</h3>

    <div class="row g-4">

        <?php if ($result->num_rows > 0): ?>

            <?php while ($row = $result->fetch_assoc()): ?>
                
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">

                            <h5 class="fw-bold">
                                <?php echo htmlspecialchars($row['title']); ?>
                            </h5>

                            <p class="text-muted small mb-2">
                                <?php echo date('M d, Y', strtotime($row['created_at'])); ?>
                            </p>

                            <p>
                                <?php 
                                    echo substr(strip_tags($row['content']), 0, 120) . "..."; 
                                ?>
                            </p>

                            <a href="article.php?id=<?php echo $row['id']; ?>" 
                               class="text-decoration-none small">
                               Read More →
                            </a>

                        </div>
                    </div>
                </div>

            <?php endwhile; ?>

        <?php else: ?>

            <p class="text-muted">No articles published yet.</p>

        <?php endif; ?>

    </div>

</div>

<!-- ================= FOOTER ================= -->
<footer class="bg-white text-center py-3 mt-5 border-top">
    <small class="text-muted">
        © <?php echo date('Y'); ?> Mindanow
    </small>
</footer>

</body>
</html>