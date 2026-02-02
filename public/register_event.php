<?php
require '../config/db.php';
require '../includes/functions.php';

auth_required();

/* CSRF check */
if (!check_csrf($_POST['csrf'] ?? '')) {
    die("Invalid CSRF token.");
}

/* Event ID check */
if (!isset($_POST['event_id'])) {
    header("Location: index.php");
    exit;
}

$user_id  = (int) $_SESSION['user_id'];
$event_id = (int) $_POST['event_id'];
$username = $_SESSION['user'] ?? '';

/* Fetch event details and current registration count */
$stmt = $pdo->prepare("
    SELECT id, title, max_participants,
           (SELECT COUNT(*) FROM registrations WHERE event_id = ?) AS reg_count
    FROM events
    WHERE id = ?
");
$stmt->execute([$event_id, $event_id]);
$event = $stmt->fetch();

if (!$event) {
    die("Event not found.");
}

$event_title = $event['title'] ?? '';
$max         = (int) $event['max_participants'];
$current     = (int) $event['reg_count'];

/* Check if user already registered */
$check = $pdo->prepare("SELECT 1 FROM registrations WHERE user_id=? AND event_id=?");
$check->execute([$user_id, $event_id]);

if ($check->fetch()) {
    header("Location: index.php?already=1");
    exit;
}

/* Check event capacity (0 = unlimited) */
if ($max !== 0 && $current >= $max) {
    header("Location: index.php?full=1");
    exit;
}

/* Register user */
$stmt = $pdo->prepare("
    INSERT INTO registrations (user_id, event_id, username, event_title)
    VALUES (?, ?, ?, ?)
");
$stmt->execute([$user_id, $event_id, $username, $event_title]);

header("Location: index.php?registered=1");
exit;
