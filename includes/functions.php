<?php
function admin_required() {
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        die("Access denied. Admins only.");
    }
}

function csrf_token() {
    if (!isset($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function check_csrf($token) {
    return isset($_SESSION['csrf']) && hash_equals($_SESSION['csrf'], $token);
}

function auth_required() {
    session_start();

    // Prevent caching
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");

    if (!isset($_SESSION['user'])) {
        header("Location: ../public/login.php");
        exit();
    }
}
?>

