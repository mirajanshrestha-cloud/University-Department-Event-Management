<?php
require '../config/db.php';
require '../includes/functions.php';

auth_required();

if (!check_csrf($_POST['csrf'] ?? '')) {
    die("Invalid CSRF token.");
}

if (!isset($_POST['event_id'])) {
    header("Location: index.php");
    exit;
}

$user_id = (int) $_SESSION['user_id'];
$event_id = (int) $_POST['event_id'];

try {
    $stmt = $pdo->prepare("
        INSERT INTO registrations (user_id, event_id)
        VALUES (?, ?)
    ");
    $stmt->execute([$user_id, $event_id]);

    header("Location: index.php?registered=1");
    exit;

} catch (PDOException $e) {

    if ($e->getCode() == 23000) {
        header("Location: index.php?already=1");
        exit;
    }

    throw $e;
}