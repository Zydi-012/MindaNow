<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

// Get total articles
$articlesResult = $conn->query("SELECT COUNT(*) AS total FROM articles");
$articlesData = $articlesResult->fetch_assoc();
$totalArticles = $articlesData['total'];

// Get total users
$usersResult = $conn->query("SELECT COUNT(*) AS total FROM users");
$usersData = $usersResult->fetch_assoc();
$totalUsers = $usersData['total'];
?>

<?php include '../includes/header.php'; ?>

<div class="container py-5">

    <!-- Page Title -->
    <div class="mb-4">
        <h3 class="fw-semibold">Dashboard</h3>
        <p class="text-muted mb-0">Welcome back, <?php echo $_SESSION['username']; ?>.</p>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4">

        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-muted">Total Articles</h6>
                    <h2 class="fw-bold"><?php echo $totalArticles; ?></h2>
                </div>
                <div class="card-footer bg-white border-0 text-end">
                    <a href="articles/index.php" class="small text-decoration-none">
                        Manage Articles →
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-muted">Total Users</h6>
                    <h2 class="fw-bold"><?php echo $totalUsers; ?></h2>
                </div>
                <div class="card-footer bg-white border-0 text-end">
                    <a href="../admin/users/index.php" class="small text-decoration-none">
                        Manage Users →
                    </a>
                </div>
            </div>
        </div>

    </div>

    <!-- Quick Actions -->
    <div class="mt-5">
        <h6 class="text-muted mb-3">Quick Actions</h6>

        <a href="articles/create.php" class="btn btn-dark btn-sm me-2">
            Add Article
        </a>

        <a href="../public/index.php" target="_blank" class="btn btn-outline-secondary btn-sm me-2">
            View Website
        </a>

        <a href="../logout.php" class="btn btn-outline-danger btn-sm">
            Logout
        </a>
    </div>

</div>

<?php include '../includes/footer.php'; ?>