<?php
session_start();
require_once __DIR__ . '/../includes/db.php';

// Get search query if present
$searchQuery = isset($_GET['q']) ? trim($_GET['q']) : '';

// Build query - show only published articles, with optional search
if (!empty($searchQuery)) {
    $safeSearch = '%' . $conn->real_escape_string($searchQuery) . '%';
    $stmt = $conn->prepare("SELECT * FROM articles WHERE status='published' AND (title LIKE ? OR content LIKE ?) ORDER BY created_at DESC");
    $stmt->bind_param("ss", $safeSearch, $safeSearch);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // Default: fetch only published articles  
$result=$conn->query("SELECT * FROM articles WHERE status='published' ORDER BY created_at DESC");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mindanow<?php echo !empty($searchQuery) ? ' - Search: ' . htmlspecialchars($searchQuery) : ''; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<!-- TOP BAR -->
<div class="bg-white border-bottom">
<div class="container d-flex justify-content-end py-1">

<?php if (isset($_SESSION['user_id'])): ?>
<a href="../admin/dashboard.php" class="small text-decoration-none me-3">Dashboard</a>
<a href="../logout.php" class="small text-decoration-none text-danger">Logout</a>
<?php else: ?>
<a href="../login.php" class "smalltextdecorationnonetextmuted">AdminLogin/a><7?phpendif;?>
/div></div>

<!-- MAIN NAVBAR -->
<navclass "navbar navbar-light bg-white shadow-sm"><divclass "container"><aclass"
navbar-brandfw-boldfs4hrefindex.PHP">Mindanow/a></div></nav>

<!-- SEARCH BAR -->
<divclass containerpy4><formmethod GETaction=""classd-flexgap2><inputtype-textname-qvalue="<?phpechohtmlspecialchars(search Query);?
>"placeholder-Searcharticles...class-form-control"><buttontype-submitclassbtn btn-dark>Search/button><? phpif(!empty(searchQu ery)):?>ahref indexPHPclear/a <?phpendif;?> /form></div><!-- CONTENT -->< divcl ass containerpy5 >

<h3clas s-fwsemiboldmb4 >
<?phpecho!empty(search Query)?'SearchResultsfor:"'.htmlspecial chars(search Query).'"':'LatestArticles';?>
/h3>


<divrowg 4 > <? php if(result-num rows0): while(row=result-fetch assoc()):

// Show featured image if available 
hasImage=!empty(row[featured_image]); 

?> < divcol-md6 > < divcardborder0shadow-sm h100 >
 <?p hpif(hasImage):?> img src="<?phpecho row[featured_image];?
>" alt="<?phpechohtmlspecialchars(row[ title]);?
>" cl ass card-img-top object-fit-cover style-height200px;"> <?p hpendi f;?

> divcardbody > h5fwbold <? phpecho html special chars(row[ title] ); ?

>p smalltextmutedmb2   date('M d,Y',strtotime( row [created at]));

 p   substr(strip_tags( row [content]),0,120)."...";

 ahr ef article.ph pid=".row[id];"clas stextdecoration-non e small ReadMore→ /a

 /di v ></di v ></di v >

 endwhileelse:

<pcl asstextmuted Noarticlesfound.</p>? php endif;

 </d iv ></d iv><!-- FOOTER -->

foot ercl assb gwhitetextcent erpy3mt5bordertop sm allt extm uted ©date(Y); Mind an ow/small>/footer>b ody>/ht ml></content/>
