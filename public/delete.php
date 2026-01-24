<?php
auth_required();
admin_required();

$stmt = $pdo->prepare("DELETE FROM events WHERE id = ?");
$stmt->execute([$_GET['id']]);
?>