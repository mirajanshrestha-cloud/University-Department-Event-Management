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
        $role = $_POST['role'];

        if (!$username || !$password || !$role) {
            $error = "All fields required.";
        } else {
            $check = $pdo->prepare("SELECT id FROM users WHERE username=?");
            $check->execute([$username]);

            if ($check->rowCount()) {
                $error = "Username already exists.";
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare(
                    "INSERT INTO users (username, password, role)
                     VALUES (?, ?, ?)"
                );
                $stmt->execute([$username, $hash, $role]);

                header("Location: login.php?registered=1");
                exit;
            }
        }
    }
}
?>

<?php require '../includes/header.php'; ?>
<link rel="stylesheet" href="../assets/style.css">

<form method="POST" class="form">
<h2>Create Account</h2>
<p class="error"><?= htmlspecialchars($error) ?></p>

<label>Username</label>
<input name="username" required>

<label>Password</label>
<input type="password" name="password" required>

<label>Register As</label>
<select name="role" required>
    <option value="">-- Select Role --</option>
    <option value="admin">Admin (Department Staff)</option>
    <option value="user">Student / Teacher</option>
</select>

<input type="hidden" name="csrf" value="<?= csrf_token() ?>">
<button>Create Account</button>
</form>

<?php require '../includes/footer.php'; ?>
