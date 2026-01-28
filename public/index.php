<?php
require '../config/db.php';
require '../includes/functions.php';
auth_required();
require '../includes/header.php';

$events = $pdo->query("SELECT * FROM events ORDER BY event_date");
?>

<h2>Event Schedule</h2>

<link rel="stylesheet" href="../assets/css/style.css">

<form action="search.php" method="GET">
    <input name="keyword" placeholder="Search events">
    <button>Search</button>
</form>

<table>
<tr>
    <th>Title</th>
    <th>Date</th>
    <th>Location</th>
    <th>Organiser</th>
    <th>Registrations</th>

    <?php if ($_SESSION['role'] === 'admin'): ?>
        <th>Actions</th>
    <?php endif; ?>
</tr>
<?php foreach ($events as $e): ?>
<tr onmouseover="loadCount(<?= (int)$e['id'] ?>)">
    <td><?= htmlspecialchars($e['title']) ?></td>
    <td><?= htmlspecialchars($e['event_date']) ?></td>
    <td><?= htmlspecialchars($e['location']) ?></td>
    <td><?= htmlspecialchars($e['organizer']) ?></td>

    <td id="count-<?= (int)$e['id'] ?>">0</td>

    <?php if ($_SESSION['role'] === 'admin'): ?>
        <td>
            <a href="edit_event.php?id=<?= (int)$e['id'] ?>">Edit</a>
            <a href="delete.php?id=<?= (int)$e['id'] ?>"
               onclick="return confirm('Delete?')">Delete</a>
        </td>
    <?php endif; ?>
</tr>
<?php endforeach; ?>
</table>

<?php require '../includes/footer.php'; ?>
