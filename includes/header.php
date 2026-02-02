<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$current_page = basename($_SERVER['PHP_SELF']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<header class="site-header">
    <h1>Event Management System</h1>
    <nav>
        <?php if (isset($_SESSION['user']) && !in_array($current_page, ['login.php', 'register.php'])): ?>
            
            <span>
                Welcome, <?= htmlspecialchars($_SESSION['user']) ?> (<?= htmlspecialchars($_SESSION['role']) ?>)
            </span>
            <span>
            <?php if ($_SESSION['role'] === 'admin'): ?>

                <?php if ($current_page === 'index.php'): ?>
                    | <a href="../public/add_event.php">Add Event</a>
                    | <a href="../public/log_sheet.php">Log Sheet</a>
                <?php endif; ?>

            <?php endif; ?>

            | <a href="../public/logout.php">Logout</a>
        <span>
            <?php else: ?>
                <a href="../public/login.php">Login</a> 
                |<a href="../public/register.php">Register</a>
            <?php endif; ?>
        </span>
    </span>
    </nav>
</header>

<main class="container">
