<?php
require '../config/db.php';
require '../includes/functions.php';
auth_required();

$keyword  = trim($_POST['keyword'] ?? '');
$category = trim($_POST['category'] ?? '');

$sql = "SELECT e.*, 
               (SELECT COUNT(*) FROM registrations r WHERE r.event_id = e.id) AS reg_count
        FROM events e
        WHERE 1=1";
$params = [];

if ($keyword !== '') {
    $sql .= " AND (title LIKE ? OR location LIKE ? OR organizer LIKE ?)";
    $params[] = "%$keyword%";
    $params[] = "%$keyword%";
    $params[] = "%$keyword%";
}

if ($category !== '') {
    $sql .= " AND category = ?";
    $params[] = $category;
}

$sql .= " ORDER BY event_date";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($events)) {
    echo "<p class='no-results'>No events found.</p>";
    exit;
}
?>

<?php foreach ($events as $e):
    $check = $pdo->prepare("SELECT 1 FROM registrations WHERE user_id=? AND event_id=?");
    $check->execute([$_SESSION['user_id'], $e['id']]);
    $already = $check->fetch();

    $max   = (int)$e['max_participants'];
    $count = (int)$e['reg_count'];

    if ($max === 0) { 
        $percent = 100; 
        $barClass = 'open'; 
        $displayText = "Everyone can attend"; 
        $isFull = false; 
    } else { 
        $percent = min(100, ($count / $max) * 100); 
        $isFull = $count >= $max; 
        $barClass = $isFull ? 'full' : 'limited'; 
        $displayText = "$count / $max"; 
    }
?>
<div class="event-card" data-event-id="<?= $e['id'] ?>" onclick="toggleActions(<?= $e['id'] ?>)">
    <h3><?= htmlspecialchars($e['title']) ?></h3>
    <p><strong>Date:</strong> <?= htmlspecialchars($e['event_date']) ?></p>
    <p><strong>Location:</strong> <?= htmlspecialchars($e['location']) ?></p>
    <p><strong>Organiser:</strong> <?= htmlspecialchars($e['organizer']) ?></p>
    <p><strong>Participants:</strong> <?= $displayText ?></p>

    <div class="progress-wrap">
        <div class="progress-bar <?= $barClass ?>" style="width:<?= $percent ?>%"></div>
    </div>

    <div class="event-actions" id="actions-<?= $e['id'] ?>" style="display:none;" onclick="event.stopPropagation();">
        <?php if ($_SESSION['role'] === 'admin'): ?>
            <div class="admin-actions">
                <a href="edit_event.php?id=<?= $e['id'] ?>" class="btn-edit">Edit</a>
                <a href="delete.php?id=<?= $e['id'] ?>" class="btn-delete" onclick="return confirm('Delete this event?')">Delete</a>
            </div>
        <?php else: ?>
            <?php if ($already): ?>
                <span class="badge registered">Registered</span>
            <?php elseif ($isFull && $max != 0): ?>
                <span class="badge full">Event Full</span>
            <?php else: ?>
                <form action="register_event.php" method="POST" class="register-form">
                    <input type="hidden" name="event_id" value="<?= $e['id'] ?>">
                    <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
                    <button type="submit" class="btn-register">Register</button>
                </form>
            <?php endif; ?>
        <?php endif; ?>
    </div>

</div>
<?php endforeach; ?>

<style>
    .progress-bar.open {
    background-color: #28a745; 
}
</style>

