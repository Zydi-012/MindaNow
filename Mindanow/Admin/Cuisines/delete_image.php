<?php

require_once '../../includes/auth.php';
require_once '../../includes/db.php';

$id = intval($_GET['id']);
$cuisine_id = intval($_GET['cuisine_id']);

// Get filename
$stmt = $conn->prepare("SELECT filename FROM cuisine_images WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$image = $result->fetch_assoc();

if($image){

$filepath = "../../uploads/cuisines/" . $image['filename'];

if(file_exists($filepath)){
unlink($filepath);
}

$delete = $conn->prepare("DELETE FROM cuisine_images WHERE id=?");
$delete->bind_param("i", $id);
$delete->execute();

}

header("Location: edit.php?id=".$cuisine_id);
exit();