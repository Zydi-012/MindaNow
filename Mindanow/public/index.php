<?php
session_start();
require_once '../includes/db.php';
?>

<!DOCTYPE html>
<html>
<head>
<title>Mindanow - Adventure News</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

<style>

body{
    background:#f4fbf6;
    font-family:'Poppins',sans-serif;
}

/* NAVBAR */

.navbar{
    background:linear-gradient(90deg,#1b5e20,#2e7d32);
}

.navbar-brand{
    font-weight:600;
    font-size:3.0rem;
}

/* HERO */

.hero{
    background:linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.5)),
    url("https://images.unsplash.com/photo-1501785888041-af3ef285b470");
    background-size:cover;
    background-position:center;
    color:white;
    padding:80px 20px;
    border-radius:12px;
    margin-bottom:40px;
}

.hero h1{
    font-weight:700;
}

/* CARDS */

.card{
    border:none;
    border-radius:15px;
    overflow:hidden;
    transition:all .25s ease;
}

.card:hover{
    transform:translateY(-6px);
    box-shadow:0 15px 35px rgba(0,0,0,.15);
}

.card-img-top{
    height:200px;
    object-fit:cover;
}

/* TITLE */

.article-title{
    color:#1b5e20;
    font-weight:600;
}

/* BUTTON */

.btn-read{
    background:#2e7d32;
    color:white;
    border-radius:30px;
    padding:6px 16px;
}

.btn-read:hover{
    background:#1b5e20;
}

/* FOOTER */

.footer{
    margin-top:60px;
    padding:20px;
    text-align:center;
    background:#1b5e20;
    color:white;
}

</style>
</head>
<body>


<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg">
<div class="container">

<a class="navbar-brand text-white" href="#">🌿 Mindanow</a>

<div class="ms-auto">

<?php if(isset($_SESSION['username'])): ?>

<a href="/Mindanow/admin/dashboard.php" class="btn btn-outline-light btn-sm me-2">Dashboard</a>
<a href="/Mindanow/admin/logout.php" class="btn btn-danger btn-sm">Logout</a>

<?php else: ?>

<a href="/Mindanow/login.php" class="btn btn-light btn-sm">Admin Login</a>

<?php endif; ?>

</div>

</div>
</nav>


<div class="container">

<!-- HERO -->

<div class="hero text-center">

<h1>Explore Mindanao</h1>
<p>Adventure, Culture, and Stories from the South</p>

</div>


<h3 class="mb-4 fw-bold text-success">Latest Adventures & News</h3>


<div class="row g-4">

<?php
$result = $conn->query("SELECT * FROM articles ORDER BY created_at DESC");

if($result->num_rows > 0):
while($row = $result->fetch_assoc()):
?>

<div class="col-md-6 col-lg-4">
    <div class="card shadow-sm h-100">
        <?php if(!empty($row['header_image'])): ?>
            <img src="/Mindanow/uploads/articles/<?php echo $row['header_image']; ?>" class="card-img-top">
        <?php else: ?>
            <img src="https://picsum.photos/600/400?random=<?php echo $row['id']; ?>" class="card-img-top">
        <?php endif; ?>
        <div class="card-body d-flex flex-column">
            <h5 class="article-title"><?php echo htmlspecialchars($row['title']); ?></h5>
            <p class="text-muted small mb-2"><?php echo date("F d, Y", strtotime($row['created_at'])); ?></p>
            <p class="flex-grow-1"><?php echo substr(strip_tags($row['content']),0,120); ?>...</p>
            <a href="article.php?id=<?php echo $row['id']; ?>" class="btn btn-read align-self-start mt-2">Read More</a>
        </div>
    </div>
</div>

</div>
</div>

</div>

<?php
endwhile;
else:
echo "<p>No articles available.</p>";
endif;
?>

</div>
</div>


<!-- FOOTER -->

<div class="footer">
© <?php echo date("Y"); ?> Mindanow | Adventure News
</div>


</body>
</html>