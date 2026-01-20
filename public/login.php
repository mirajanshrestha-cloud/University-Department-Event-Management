<?php
require '../config/db.php';

$error = "";

if ($_POST) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username=?");
    $stmt->execute([$_POST['username']]);
    $user = $stmt->fetch();

    if ($user && password_verify($_POST['password'], $user['password'])) {
        $_SESSION['user'] = $user['username'];
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

<button>Login</button>
</form>

<?php require '../includes/footer.php'; ?>
