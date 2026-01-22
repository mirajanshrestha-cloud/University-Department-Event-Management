<?php
require '../config/db.php';
require '../includes/functions.php';
auth_required();
require '../includes/header.php';

$events = $pdo->query("SELECT * FROM events ORDER BY event_date");
?>

<h2>Event Schedule</h2>
   <link re="stylesheet" href="../assets/style.css">
<form action="search.php">
<input name="keyword" placeholder="Search events">
<button>Search</button>
</form>

<table>
<tr>
<th>Title</th><th>Date</th><th>Location</th><th>Registrations</th><th>Actions</th>
</tr>

<?php foreach ($events as $e): ?>
<tr onmouseover="loadCount(<?= $e['id'] ?>)">
<td><?= htmlspecialchars($e['title']) ?></td>
<td><?= $e['event_date'] ?></td>
<td><?= htmlspecialchars($e['location']) ?></td>
<td id="count-<?= $e['id'] ?>">0</td>
<td>
<a href="edit_event.php?id=<?= $e['id'] ?>">Edit</a>
<a href="delete_event.php?id=<?= $e['id'] ?>" onclick="return confirm('Delete?')">Delete</a>
</td>
</tr>
<?php endforeach; ?>
</table>

<?php require '../includes/footer.php'; ?>
