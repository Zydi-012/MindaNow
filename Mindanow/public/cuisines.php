<?php
require_once '../includes/db.php';

$id = intval($_GET['id']);

// Fetch cuisine
$stmt = $conn->prepare("SELECT * FROM cuisines WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$cuisine = $result->fetch_assoc();

if (!$cuisine) {
    header("Location: index.php");
    exit();
}

// Fetch gallery images
$images_stmt = $conn->prepare("SELECT filename FROM cuisine_images WHERE cuisine_id=?");
$images_stmt->bind_param("i", $id);
$images_stmt->execute();
$images_result = $images_stmt->get_result();
$images = $images_result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>

<title><?php echo htmlspecialchars($cuisine['title']); ?> - Mindanow</title>

<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>

body{
    background:#f4fbf6;
    font-family:'Poppins',sans-serif;
}

/* NAVBAR */

.navbar{
    background:linear-gradient(90deg,#1b5e20,#2e7d32);
}

.navbar a{
    color:white !important;
}

/* HERO */

.hero{
    background:linear-gradient(rgba(0,0,0,.5),rgba(0,0,0,.5)),
    url("https://picsum.photos/1200/500?random=<?php echo $cuisine['id']; ?>");

    background-size:cover;
    background-position:center;

    color:white;
    padding:90px 20px;
}

.hero h1{
    font-weight:700;
}

/* ARTICLE */

.article-container{
    max-width:800px;
    margin:auto;
}

.article-meta{
    color:#6c757d;
    font-size:.9rem;
}

/* CONTENT */

.article-content{
    line-height:1.9;
    font-size:1.05rem;
}

.article-content p{
    margin-bottom:1.2rem;
}

/* BACK BUTTON */

.back-link{
    text-decoration:none;
    color:#2e7d32;
}

.back-link:hover{
    text-decoration:underline;
}

/* FOOTER */

.footer{
    margin-top:60px;
    padding:20px;
    background:#1b5e20;
    color:white;
    text-align:center;
}

</style>

</head>

<body>

<!-- NAVBAR -->

<nav class="navbar navbar-expand-lg">
<div class="container">

<a class="navbar-brand fw-bold" href="index.php">
🌿 Mindanow
</a>

</div>
</nav>


<!-- HERO HEADER -->

<div class="hero text-center">

<div class="container article-container">

<h1>
<?php echo htmlspecialchars($cuisine['title']); ?>
</h1>

<p class="article-meta mt-3">
Published <?php echo date('F d, Y', strtotime($cuisine['created_at'])); ?>
</p>

</div>

</div>



<!-- CUISINE BODY -->

<div class="container py-5">

<div class="article-container">

<?php if(!empty($images)): ?>
<div id="cuisineGallery" class="carousel slide mb-4" data-bs-ride="carousel">
  <div class="carousel-inner">
    <?php foreach($images as $index => $img): ?>
      <div class="carousel-item <?php if($index==0) echo 'active'; ?>">
        <img src="/Mindanow/uploads/cuisines/<?php echo $img['filename']; ?>" class="d-block w-100 rounded">
      </div>
    <?php endforeach; ?>
  </div>

  <?php if(count($images) > 1): ?>
  <button class="carousel-control-prev" type="button" data-bs-target="#cuisineGallery" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
  </button>

  <button class="carousel-control-next" type="button" data-bs-target="#cuisineGallery" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
  </button>
  <?php endif; ?>

</div>
<?php endif; ?>


<div class="article-content">

<?php echo nl2br(htmlspecialchars($cuisine['description'])); ?>

</div>


<hr class="my-5">

<a href="index.php" class="back-link">
← Back to Cuisines
</a>

</div>

</div>



<!-- FOOTER -->

<div class="footer">

© <?php echo date('Y'); ?> Mindanow | Mindanao Cuisines

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>