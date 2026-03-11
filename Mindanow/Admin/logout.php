<?php
session_start();

// Clear session
session_unset();
session_destroy();

// Redirect to homepage
header("Location: /Mindanow/public/index.php");
exit();
?>