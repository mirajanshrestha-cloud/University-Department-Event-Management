<?php
require '../config/db.php';
require '../includes/functions.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username=?");
    $stmt->execute([$_POST['username']]);
    $user = $stmt->fetch();

    if ($user && password_verify($_POST['password'], $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user']    = $user['username'];
        $_SESSION['role']    = $user['role'];
        header("Location: index.php");
        exit;
    } else {
        $error = "Invalid login details.";
    }
}

require '../includes/header.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form class="form" method="POST">
    <h2>Login</h2>
    <p class="error"><?= htmlspecialchars($error) ?></p>

    <label>Username</label>
    <input name="username" required>

    <label>Password</label>
    <input type="password" name="password" required>

    <button type="submit">Login</button>
</form>
</body>
</html>
<style>
    .page-container {
        flex: 1;
        margin-top: 50px;
        padding: 134px 20px; 
    }
</style>

<?php require '../includes/footer.php'; ?>