<?php
require_once '../../Includes/auth.php';
require_once '../../Includes/db.php';
require_once '../../Includes/upload.php';

$id = intval($_GET['id'] ?? 0);

$stmt = $conn->prepare("SELECT image FROM destinations WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$destination = $stmt->get_result()->fetch_assoc();

if ($destination) {
    if ($destination['image']) {
        deleteImage($destination['image']);
    }
    
    $stmt = $conn->prepare("DELETE FROM destinations WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: index.php");
exit();
?>
