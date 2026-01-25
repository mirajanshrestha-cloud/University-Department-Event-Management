<?php
require '../config/db.php';
require '../includes/header.php';

$kw = "%" . $_GET['keyword'] . "%";
$stmt = $pdo->prepare("SELECT * FROM events WHERE title LIKE ?");
$stmt->execute([$kw]);
?>

<h2>Search Results</h2>

<?php foreach ($stmt as $e): ?>
<p><?= htmlspecialchars($e['title']) ?> (<?= $e['event_date'] ?>)</p>
<?php endforeach; ?>
<?php require '../includes/footer.php'; ?>
