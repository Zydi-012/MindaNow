<?php

require_once '../../includes/auth.php';
require_once '../../includes/db.php';

$id=intval($_GET['id']);

$conn->query("DELETE FROM announcements WHERE id=$id");

header("Location:index.php");
exit();