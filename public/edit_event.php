<?php
$stmt = $pdo->prepare("UPDATE events SET title=?, category=?, organizer=?, event_date=?, location=? WHERE id=?");
$stmt->execute([
    $_POST['title'],
    $_POST['category'],
    $_POST['organizer'],
    $_POST['event_date'],
    $_POST['location'],
    $_POST['id']
]);
?>
