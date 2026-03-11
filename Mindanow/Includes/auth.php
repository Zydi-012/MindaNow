<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    header("Location: /Mindanow/login.php");
    exit();
}

// Optional helper functions
function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function isEditor() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'editor';
}

// Example: prevent non-admins from accessing users management
function requireAdmin() {
    if (!isAdmin()) {
        echo "<h4 class='text-center mt-5'>Access Denied. Admins Only.</h4>";
        exit();
    }
}

// Example: prevent unauthorized page access
function requireRole($roles = []) {
    if (!in_array($_SESSION['role'], $roles)) {
        echo "<h4 class='text-center mt-5'>Access Denied.</h4>";
        exit();
    }
}