<?php
require '../config/db.php';
require '../includes/functions.php';
auth_required();

$keyword = trim($_POST['keyword'] ?? '');
$category = trim($_POST['category'] ?? '');

// Base SQL
$sql = "SELECT e.*, (SELECT COUNT(*) FROM registrations r WHERE r.event_id = e.id) AS reg_count
        FROM events e
        WHERE 1=1 ";
$params = [];

// Keyword search
if ($keyword !== '') {
    $sql .= " AND (title LIKE ? OR location LIKE ? OR organizer LIKE ?) ";
    $params[] = "%$keyword%";
    $params[] = "%$keyword%";
    $params[] = "%$keyword%";
}

// Category filter
if ($category !== '') {
    $sql .= " AND category = ? ";
    $params[] = $category;
}

$sql .= " ORDER BY event_date";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($events)) {
    echo "<p style='text-align:center; color:#555;'>No events found.</p>";
} else {
    foreach ($events as $e):
        $check = $pdo->prepare("SELECT 1 FROM registrations WHERE user_id=? AND event_id=?");
        $check->execute([$_SESSION['user_id'], $e['id']]);
        $already = $check->fetch();

        $max = (int)$e['max_participants'];
        $count = (int)$e['reg_count'];

        if ($max === 0) { 
            $percent=100; 
            $barColor='background-color:#28a745;'; 
            $displayText="Everyone can attend"; 
            $isFull=false; 
        } else { 
            $percent = min(100, ($count/$max)*100); 
            $isFull = $count >= $max; 
            $barColor = $isFull ? 'background-color:#dc3545;' : 'background-color:#ffc107;'; 
            $displayText="$count/$max"; 
        }
?>
<div class="event-card" data-event-id="<?= $e['id'] ?>" onclick="toggleActions(<?= $e['id'] ?>)" 
     style="color:#222; background:#fff; border:1px solid #ddd; border-radius:10px; padding:15px 20px; box-shadow:0 2px 6px rgba(0,0,0,0.1); cursor:pointer; margin-bottom:15px;">
    <h3 style="color:#222;"><?= htmlspecialchars($e['title']) ?></h3>
    <p style="color:#555;"><strong>Date:</strong> <?= htmlspecialchars($e['event_date']) ?></p>
    <p style="color:#555;"><strong>Location:</strong> <?= htmlspecialchars($e['location']) ?></p>
    <p style="color:#555;"><strong>Organiser:</strong> <?= htmlspecialchars($e['organizer']) ?></p>
    <p style="color:#555;"><strong>Participants:</strong> <?= $displayText ?></p>

    <div class="progress-wrap" style="background:#e0e0e0; border-radius:6px; overflow:hidden; height:12px; margin-top:6px;">
        <div class="progress-bar" style="height:100%; <?= $barColor ?> width:<?= $percent ?>%; transition: width 0.3s;"></div>
    </div>

    <div class="event-actions" id="actions-<?= $e['id'] ?>" style="display:none; margin-top:10px; padding-top:10px; border-top:1px solid #eee;">
        <?php if ($already): ?>
            <span style="display:inline-block; background:#155724; color:#fff; font-weight:bold; padding:4px 10px; border-radius:4px;">Registered</span>
        <?php elseif ($isFull && $max != 0): ?>
            <span style="display:inline-block; background:#721c24; color:#fff; font-weight:bold; padding:4px 10px; border-radius:4px;">Event Full</span>
        <?php else: ?>
            <form action="register_event.php" method="POST" style="display:inline;">
                <input type="hidden" name="event_id" value="<?= $e['id'] ?>">
                <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
                <button type="submit" 
                        style="background:#28a745; color:#fff; padding:6px 12px; border-radius:4px; border:none; font-weight:bold; cursor:pointer; margin-right:5px;"
                        onmouseover="this.style.background='#218838'" onmouseout="this.style.background='#28a745'">
                        Register
                </button>
            </form>
        <?php endif; ?>

        <?php if ($_SESSION['role']==='admin'): ?>
            <div class="admin-actions" style="margin-top:10px;">
                <a href="edit_event.php?id=<?= $e['id'] ?>" 
                   style="background:#007bff; color:#fff; padding:6px 12px; border-radius:4px; text-decoration:none; margin-right:5px; font-weight:bold;"
                   onmouseover="this.style.background='#0056b3'" onmouseout="this.style.background='#007bff'">Edit</a>
                <a href="delete.php?id=<?= $e['id'] ?>" 
                   style="background:#dc3545; color:#fff; padding:6px 12px; border-radius:4px; text-decoration:none; font-weight:bold;"
                   onclick="return confirm('Delete this event?')"
                   onmouseover="this.style.background='#c82333'" onmouseout="this.style.background='#dc3545'">Delete</a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php
    endforeach;
}
?>
