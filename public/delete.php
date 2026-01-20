<?php
$stmt = $pdo->prepare("DELETE FROM events WHERE id = ?");
$stmt->execute([$_GET['id']]);
?>