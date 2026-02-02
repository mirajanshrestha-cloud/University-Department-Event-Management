<?php
require '../config/db.php';
require '../includes/functions.php';
auth_required();
admin_required();

if (!isset($_GET['id'])) {
header("Location: index.php");
exit;
}

$id = (int) $_GET['id'];
$stmt = $pdo->prepare("SELECT id FROM events WHERE id = ?");
$stmt->execute([$id]);
if (!$stmt->fetch()) {
	header("Location: index.php?error=notfound");
	exit;
}


$stmt = $pdo->prepare("DELETE FROM events WHERE id = ?");
$stmt->execute([$id]);


header("Location: index.php?deleted=1");
exit;