<?php
require '../config/db.php';
require '../includes/functions.php';
auth_required();
require '../includes/header.php';

// Get the search keyword safely
$kw = "%" . ($_GET['keyword'] ?? '') . "%";

// Fetch matching events
$stmt = $pdo->prepare("SELECT * FROM events WHERE title LIKE ? ORDER BY event_date");
$stmt->execute([$kw]);
$events = $stmt->fetchAll();
?>

<div class="page-container">
    <div class="search-filter">
        <h2 style="text-align:center;">Search Results</h2>

        <form action="search.php" method="GET" class="search-form">
            <input name="keyword" placeholder="Search events" value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
            <button type="submit">Search</button>
        </form>
    </div>

    <div class="event-grid">
        <?php if ($events): ?>
            <?php foreach ($events as $e):
                // Check if current user is already registered
                $check = $pdo->prepare("SELECT 1 FROM registrations WHERE user_id=? AND event_id=?");
                $check->execute([$_SESSION['user_id'], $e['id']]);
                $already = $check->fetch();
            ?>
            <div class="event-card" onclick="toggleActions(<?= (int)$e['id'] ?>)">
                <h3><?= htmlspecialchars($e['title']) ?></h3>
                <p><strong>Date:</strong> <?= htmlspecialchars($e['event_date']) ?></p>
                <p><strong>Location:</strong> <?= htmlspecialchars($e['location']) ?></p>
                <p><strong>Organiser:</strong> <?= htmlspecialchars($e['organizer']) ?></p>

                <div class="event-actions" id="actions-<?= (int)$e['id'] ?>" style="display:none;">
                    <?php if ($already): ?>
                        <span class="registered">Registered</span>
                    <?php else: ?>
                        <form action="register_event.php" method="POST">
                            <input type="hidden" name="event_id" value="<?= (int)$e['id'] ?>">
                            <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
                            <button type="submit" class="btn-register">Register</button>
                        </form>
                    <?php endif; ?>

                    <?php if ($_SESSION['role'] === 'admin'): ?>
                        <div class="admin-actions">
                            <a href="edit_event.php?id=<?= (int)$e['id'] ?>" class="btn-edit">Edit</a>
                            <a href="delete.php?id=<?= (int)$e['id'] ?>"
                               class="btn-delete"
                               onclick="return confirm('Delete this event?')">Delete</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="text-align:center; font-style:italic;">No events found matching your search.</p>
        <?php endif; ?>
    </div>
</div>

<?php require '../includes/footer.php'; ?>
<style>
    .page-container {
        padding-bottom: 160px; 
        margin-bottom: 90px;
    }
</style>