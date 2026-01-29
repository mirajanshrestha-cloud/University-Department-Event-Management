<?php
require '../config/db.php';
require '../includes/functions.php'; // must start session here

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
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
?>

<?php require '../includes/header.php'; ?>

<form class="form" method="POST">
    <h2>Login</h2>

    <p class="error"><?= htmlspecialchars($error) ?></p>

    <label>Username</label>
    <input name="username" required>

    <label>Password</label>
    <input type="password" name="password" required>

    <button type="submit">Login</button>
</form>

<?php require '../includes/footer.php'; ?>