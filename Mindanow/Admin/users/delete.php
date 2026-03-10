<?php
require_once '../../includes/auth.php';
require_once '../../includes/db.php';

$id = intval($_GET['id']);

// Prevent deleting yourself
if($id == $_SESSION['user_id']){
    header("Location: index.php");
    exit();
}

$stmt = $conn->prepare("DELETE FROM users WHERE id=?");
$stmt->bind_param("i",$id);
$stmt->execute();

header("Location: index.php");
exit();