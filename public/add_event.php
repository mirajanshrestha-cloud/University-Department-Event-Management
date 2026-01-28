<?php
require '../config/db.php';
require '../includes/functions.php';

auth_required();
admin_required();

require '../includes/header.php';

/* HANDLE FORM SUBMISSION */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!check_csrf($_POST['csrf'] ?? '')) {
        die("Invalid CSRF token.");
    }

    $stmt = $pdo->prepare("
        INSERT INTO events (title, category, organizer, event_date, location)
        VALUES (?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        $_POST['title'],
        $_POST['category'],
        $_POST['organiser'],
        $_POST['event_date'],
        $_POST['location']
    ]);

    header("Location: index.php?added=1");
    exit;
}
?>

<h2>Add Event</h2>

<form method="POST" class="form">

    <label>Title</label>
    <input name="title" required>

    <label>Category</label>
    <input name="category" required>

    <label>Organiser</label>
    <input name="organiser" required>

    <label>Date</label>
    <input type="date" name="event_date" required>

    <label>Location</label>
    <input name="location" required>

    <input type="hidden" name="csrf" value="<?= csrf_token() ?>">

    <button type="submit">Add Event</button>
    <a href="index.php" class="btn-secondary">Cancel</a>

</form>

<?php require '../includes/footer.php'; ?>