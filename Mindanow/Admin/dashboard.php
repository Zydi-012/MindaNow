<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

/* ---------------------------
   TOTAL ARTICLES
--------------------------- */

$articlesResult = $conn->query("SELECT COUNT(*) AS total FROM articles");
$articlesData = $articlesResult->fetch_assoc();
$totalArticles = $articlesData['total'];


/* ---------------------------
   TOTAL ANNOUNCEMENTS
--------------------------- */

$announcementsResult = $conn->query("SELECT COUNT(*) AS total FROM announcements");
$announcementsData = $announcementsResult->fetch_assoc();
$totalAnnouncements = $announcementsData['total'];


/* ---------------------------
   TOTAL CUISINES
--------------------------- */

$cuisinesResult = $conn->query("SELECT COUNT(*) AS total FROM cuisines");
$cuisinesData = $cuisinesResult->fetch_assoc();
$totalCuisines = $cuisinesData['total'];


/* ---------------------------
   TOTAL USERS (ADMIN ONLY)
--------------------------- */

$totalUsers = 0;

if (isAdmin()) {
    $usersResult = $conn->query("SELECT COUNT(*) AS total FROM users");
    $usersData = $usersResult->fetch_assoc();
    $totalUsers = $usersData['total'];
}

?>

<?php include '../includes/header.php'; ?>

<div class="container py-5">

<!-- PAGE TITLE -->

<div class="mb-4">
<h3 class="fw-semibold">Dashboard</h3>

<p class="text-muted mb-0">
Welcome back, <?php echo htmlspecialchars($_SESSION['username']); ?>.
</p>
</div>


<!-- STATS CARDS -->

<div class="row g-4">

<!-- ARTICLES -->

<div class="col-md-6">
<div class="card border-0 shadow-sm h-100">

<div class="card-body">
<h6 class="text-muted">Total Articles</h6>
<h2 class="fw-bold"><?php echo $totalArticles; ?></h2>
</div>

<div class="card-footer bg-white border-0 text-end">
<a href="/Mindanow/admin/articles/index.php" class="small text-decoration-none">
Manage Articles →
</a>
</div>

</div>
</div>


<!-- CUISINES -->

<div class="col-md-6">
<div class="card border-0 shadow-sm h-100">

<div class="card-body">
<h6 class="text-muted">Total Cuisine Articles</h6>
<h2 class="fw-bold"><?php echo $totalCuisines; ?></h2>
</div>

<div class="card-footer bg-white border-0 text-end">
<a href="/Mindanow/admin/cuisines/index.php" class="small text-decoration-none">
Manage Cuisines →
</a>
</div>

</div>
</div>


<!-- ANNOUNCEMENTS -->

<div class="col-md-6">
<div class="card border-0 shadow-sm h-100">

<div class="card-body">
<h6 class="text-muted">Total Announcements</h6>
<h2 class="fw-bold"><?php echo $totalAnnouncements; ?></h2>
</div>

<div class="card-footer bg-white border-0 text-end">
<a href="/Mindanow/admin/announcements/index.php" class="small text-decoration-none">
Manage Announcements →
</a>
</div>

</div>
</div>


<!-- USERS (ADMIN ONLY) -->

<?php if (isAdmin()): ?>

<div class="col-md-6">
<div class="card border-0 shadow-sm h-100">

<div class="card-body">
<h6 class="text-muted">Total Users</h6>
<h2 class="fw-bold"><?php echo $totalUsers; ?></h2>
</div>

<div class="card-footer bg-white border-0 text-end">
<a href="/Mindanow/admin/users/index.php" class="small text-decoration-none">
Manage Users →
</a>
</div>

</div>
</div>

<?php endif; ?>

</div>


<!-- QUICK ACTIONS -->

<div class="mt-5">

<h6 class="text-muted mb-3">Quick Actions</h6>

<a href="/Mindanow/public/index.php" target="_blank" class="btn btn-dark btn-sm me-2">
View Website
</a>

<a href="/Mindanow/admin/logout.php" class="btn btn-dark btn-sm me-2">
Logout
</a>

</div>

</div>

<?php include '../includes/footer.php'; ?>