<?php
require_once '../../includes/auth.php';
require_once '../../includes/db.php';

$image_id = intval($_GET['id']);
$article_id = intval($_GET['article_id']);

// Get filename
$stmt = $conn->prepare("SELECT filename FROM article_images WHERE id=?");
$stmt->bind_param("i", $image_id);
$stmt->execute();
$result = $stmt->get_result();
$image = $result->fetch_assoc();

if($image){
    $file = "../../uploads/articles/".$image['filename'];
    if(file_exists($file)) unlink($file); // delete file

    // Delete record
    $del_stmt = $conn->prepare("DELETE FROM article_images WHERE id=?");
    $del_stmt->bind_param("i",$image_id);
    $del_stmt->execute();
}

// Redirect back to edit page
header("Location: edit.php?id=$article_id");
exit();
?>