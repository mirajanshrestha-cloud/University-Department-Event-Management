<!DOCTYPE html>
<html>
<head>
    <title>Event Management</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <nav>
    <a href="index.php">Home</a>

    <?php if ($_SESSION['role'] === 'admin'): ?>
        <a href="add_event.php">Add Event</a>
    <?php endif; ?>

    <a href="logout.php">Logout</a>
</nav>
</head>
<body>

<header>
    <h1>University Event Management</h1>
</header>



