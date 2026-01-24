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
    if (!isset($_SESSION['user'])) {
        header("Location: login.php");
        exit;
    }
}
