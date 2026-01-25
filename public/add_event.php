<?php
auth_required();
admin_required();   // ✅ ONLY ADMIN

require '../config/db.php';
require '../includes/functions.php';
auth_required();

if ($_POST && check_csrf($_POST['csrf'])) {
    $stmt = $pdo->prepare(
        "INSERT INTO events VALUES (NULL, ?, ?, ?, ?, ?)"
    );
    $stmt->execute([
        $_POST['title'], $_POST['category'],
        $_POST['organizer'], $_POST['event_date'], $_POST['location']
    ]);
    header("Location: index.php");
}
require '../includes/header.php';
?>

<html>
<head>
    <h2>Add Event</h2>
    <link re="stylesheet" href="../assets/style.css">
</head>
<body>
<form method="POST" class="form">
<label>Title</label>
<input name="title" required>

<label>Category</label>
<input name="category">

<label>Organizer</label>
<input name="organizer">

<label>Date</label>
<input type="date" name="event_date">

<label>Location</label>
<input name="location">

<input type="hidden" name="csrf" value="<?= csrf_token() ?>">
<button>Add Event</button>
</form>
</body>
</html>
<?php require '../includes/footer.php'; ?>
