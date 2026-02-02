<?php
require '../config/db.php';
require '../includes/functions.php';

auth_required();
admin_required();
require '../includes/header.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = (int) $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
$stmt->execute([$id]);
$event = $stmt->fetch();

if (!$event) {
    echo "<p>Event not found.</p>";
    require '../includes/footer.php';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!check_csrf($_POST['csrf'] ?? '')) {
        die("Invalid CSRF token.");
    }

    try {
        $stmt = $pdo->prepare("
            UPDATE events 
            SET title = ?, category = ?, organizer = ?, event_date = ?, location = ?
            WHERE id = ?
        ");

        $stmt->execute([
            $_POST['title'],
            $_POST['category'],
            $_POST['organiser'],
            $_POST['event_date'],
            $_POST['location'],
            $id
        ]);

        header("Location: index.php?updated=1");
        exit;

    } catch (PDOException $e) {
        echo "<pre>DB ERROR:\n" . $e->getMessage() . "</pre>";
        exit;
    }
}
?>

<form method="POST" class="form">

    <label>Title</label>
    <input name="title" value="<?= htmlspecialchars($event['title']) ?>" required>

    <label>Category</label>
    <input name="category" value="<?= htmlspecialchars($event['category']) ?>" required>

    <label>Organiser</label>
    <input name="organiser" value="<?= htmlspecialchars($event['organiser']) ?>" required>

    <label>Event Date</label>
    <input type="date" name="event_date" value="<?= htmlspecialchars($event['event_date']) ?>" required>

    <label>Location</label>
    <input name="location" value="<?= htmlspecialchars($event['location']) ?>" required>

    <input type="hidden" name="csrf" value="<?= csrf_token() ?>">

    <button type="submit">Update Event</button>
<button type="button" id="btn-secondary" onclick="window.location.href='index.php'" style="background-color:#dc3545; color:#fff; padding:10px 16px; border:none; border-radius:4px; font-weight:bold; cursor:pointer; transition:0.2s;">Cancel</button></form>

<?php require '../includes/footer.php'; ?>
