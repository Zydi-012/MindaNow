<?php
require_once '../Includes/auth.php';
require_once '../Includes/db.php';
require_once '../Includes/visitor_tracker.php';

// Get total articles
$articlesResult = $conn->query("SELECT COUNT(*) AS total FROM articles");
$articlesData = $articlesResult->fetch_assoc();
$totalArticles = $articlesData['total'];

// Get total unique visitors
$totalVisitors = getTotalVisitors($conn);
?>

<?php include '../Includes/header.php'; ?>

<div class="top-bar">
    <h4 class="mb-0">Dashboard</h4>
    <span class="text-muted">Welcome back, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
</div>

<div class="container-fluid">

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">

        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Total Articles</h6>
                            <h2 class="fw-bold mb-0"><?php echo $totalArticles; ?></h2>
                            <small class="text-muted">Published articles</small>
                        </div>
                        <div style="font-size: 3rem; color: #1a3a2a; opacity: 0.1;">
                            <i class="fas fa-newspaper"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Total Visitors</h6>
                            <h2 class="fw-bold mb-0"><?php echo $totalVisitors; ?></h2>
                            <small class="text-muted">Unique website visitors</small>
                        </div>
                        <div style="font-size: 3rem; color: #2d6a4f; opacity: 0.1;">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Quick Stats -->
    <div class="row g-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-4">Quick Overview</h5>
                    <div class="row text-center">
                        <?php
                        $stats = [
                            ['table' => 'destinations', 'icon' => 'map-marker-alt', 'label' => 'Destinations'],
                            ['table' => 'cuisine', 'icon' => 'utensils', 'label' => 'Cuisine'],
                            ['table' => 'events', 'icon' => 'calendar', 'label' => 'Events'],
                            ['table' => 'advisories', 'icon' => 'exclamation-triangle', 'label' => 'Advisories'],
                            ['table' => 'gallery', 'icon' => 'images', 'label' => 'Gallery'],
                            ['table' => 'map_pins', 'icon' => 'map-pin', 'label' => 'Map Pins']
                        ];
                        
                        foreach ($stats as $stat) {
                            $result = $conn->query("SELECT COUNT(*) as total FROM {$stat['table']}");
                            $count = $result ? $result->fetch_assoc()['total'] : 0;
                            echo "<div class='col-md-2 col-sm-4 col-6 mb-3'>";
                            echo "<i class='fas fa-{$stat['icon']} fa-2x mb-2' style='color: #1a3a2a;'></i>";
                            echo "<h4 class='mb-0'>{$count}</h4>";
                            echo "<small class='text-muted'>{$stat['label']}</small>";
                            echo "</div>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include '../Includes/footer.php'; ?>