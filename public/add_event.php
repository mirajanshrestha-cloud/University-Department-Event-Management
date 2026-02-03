<?php
require '../config/db.php';
require '../includes/functions.php';

auth_required();
admin_required();

require '../includes/header.php';

$error = "";

/* HANDLE FORM SUBMISSION */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!check_csrf($_POST['csrf'] ?? '')) {
        die("Invalid CSRF token.");
    }

    $title = trim($_POST['title'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $organiser = trim($_POST['organiser'] ?? '');
    $event_date = $_POST['event_date'] ?? '';
    $location = trim($_POST['location'] ?? '');
    $max_participants = trim($_POST['max_participants'] ?? '');

    // Treat empty or 0 as unlimited
    $max_participants = (int)$max_participants;
    if ($max_participants < 1) {
        $max_participants = 0; // 0 = unlimited
    }

    // Validate required fields
    if (!$title || !$category || !$organiser || !$event_date || !$location) {
        $error = "All fields except Max Participants are required.";
    } else {
        // Insert into database
        $stmt = $pdo->prepare("
            INSERT INTO events (title, category, organizer, event_date, location, max_participants)
            VALUES (?, ?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $title,
            $category,
            $organiser,
            $event_date,
            $location,
            $max_participants
        ]);

        header("Location: index.php?added=1");
        exit;
    }
}
?>

<?php if ($error): ?>
    <p class="error"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

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

    <!-- Max Participants: leave blank or 0 for unlimited -->
    <label>Max Participants (0 for unlimited)</label>
    <input type="number" name="max_participants" min="0" placeholder="0 for unlimited">

    <input type="hidden" name="csrf" value="<?= csrf_token() ?>">

    <button type="submit">Add Event</button>

    <button type="button"
        id="btn-secondary"
        onclick="window.location.href='index.php'"
        style="background-color:#dc3545; color:#fff; padding:10px 16px; border:none; border-radius:4px; font-weight:bold; cursor:pointer;">
        Cancel
    </button>
</form>

<?php require '../includes/footer.php'; ?>

<style>
.page-container {
    flex: 1;
    padding-bottom: 26px;
}

.error {
    color: red;
    font-weight: bold;
    text-align: center;
}
</style>
