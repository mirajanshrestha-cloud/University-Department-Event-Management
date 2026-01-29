<?php
require '../config/db.php';
require '../includes/functions.php';
auth_required();
require '../includes/header.php';
$events = $pdo->query("
    SELECT e.*, 
           (SELECT COUNT(*) FROM registrations r WHERE r.event_id = e.id) AS reg_count
    FROM events e
    ORDER BY event_date
");
?>

<h2>Event Schedule</h2>

<link rel="stylesheet" href="../assets/style.css">

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
    <td><?= (int)$e['reg_count'] ?></td>
    <!-- <td id="count-<?= (int)$e['id'] ?>">0</td> -->

    <?php if ($_SESSION['role'] === 'admin'): ?>
        <td>
            <a href="edit_event.php?id=<?= (int)$e['id'] ?>">Edit</a>
            <a href="delete.php?id=<?= (int)$e['id'] ?>"
               onclick="return confirm('Delete?')">Delete</a>
        </td>
    <?php endif; ?>
    <td>
    <form action="register_event.php" method="POST" style="display:inline;">
        <input type="hidden" name="event_id" value="<?= (int)$e['id'] ?>">
        <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
        <button type="submit" class="btn-register">Register</button>
    </form>
</td>
</tr>
<?php endforeach; ?>
</table>
<?php
$check = $pdo->prepare("SELECT 1 FROM registrations WHERE user_id=? AND event_id=?");
$check->execute([$_SESSION['user_id'], $e['id']]);
$already = $check->fetch();
?>

<?php if ($already): ?>
    <span class="registered">Registered</span>
<?php else: ?>
    <form action="register_event.php" method="POST" style="display:inline;">
        <input type="hidden" name="event_id" value="<?= (int)$e['id'] ?>">
        <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
        <button type="submit" class="btn-register">Register</button>
    </form>
<?php endif; ?>

<?php require '../includes/footer.php'; ?>
