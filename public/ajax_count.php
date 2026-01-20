<?php
require '../config/db.php';

$stmt = $pdo->prepare(
  "SELECT COUNT(*) FROM participants WHERE event_id = ?"
);
$stmt->execute([$_GET['event_id']]);

echo $stmt->fetchColumn();
?>