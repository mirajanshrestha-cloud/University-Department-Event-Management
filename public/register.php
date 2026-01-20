<?php
require '../config/db.php';
require '../includes/functions.php';

$error = "";

if ($_POST) {
    if (!check_csrf($_POST['csrf'])) {
        $error = "Invalid request.";
    } else {
        $username = trim($_POST['username']);
        $password = $_POST['password'];

        if (!$username || !$password) {
            $error = "All fields required.";
        } else {
            $check = $pdo->prepare("SELECT id FROM users WHERE username=?");
            $check->execute([$username]);

            if ($check->rowCount()) {
                $error = "Username already exists.";
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO users VALUES (NULL, ?, ?)");
                $stmt->execute([$username, $hash]);
                header("Location: login.php?registered=1");
                exit;
            }
        }
    }
}
?>

<?php require '../includes/header.php'; ?>

<form method="POST" class="form">
<h2>Create Account</h2>
<p class="error"><?= htmlspecialchars($error) ?></p>

<label>Username</label>
<input name="username" required>

<label>Password</label>
<input type="password" name="password" required>

<input type="hidden" name="csrf" value="<?= csrf_token() ?>">
<button>Create Account</button>
</form>

<?php require '../includes/footer.php'; ?>
