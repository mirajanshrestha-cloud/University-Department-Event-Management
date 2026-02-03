<?php
require '../config/db.php';
require '../includes/functions.php';

auth_required();
admin_required();
require '../includes/header.php';

$stmt = $pdo->query("
    SELECT event_title, username, registered_at
    FROM registrations
    ORDER BY event_title, registered_at
");

$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="topic">    
    <h2 style="text-align:center;">Participant Log Sheet</h2>
</div>
<div class="table-container">

    <?php if ($rows): ?>
        <table border="1" width="70%" cellpadding="10" cellspacing="0" style="background:#fff;">
            <thead style="background:#2c3e50; color:#fff;">
                <tr>
                    <th>Event</th>
                    <th>Participant</th>
                    <th>Registered At</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $r): ?>
                    <tr>
                        <td><center><?= htmlspecialchars($r['event_title']) ?></td>
                        <td><center><?= htmlspecialchars($r['username']) ?></td>
                        <td><center><?= htmlspecialchars($r['registered_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="text-align:center; font-style:italic;">
            No registrations yet.
        </p>
    <?php endif; ?>
</div>

<?php require '../includes/footer.php'; ?>
<style>
    .table-container {
        padding-bottom: 70px ; 
        padding-left: 300px;
    }
</style>