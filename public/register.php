<?php
require '../config/db.php';
require '../includes/functions.php';

$error = "";
$username = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!check_csrf($_POST['csrf'] ?? '')) {
        $error = "Invalid request.";
    } else {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm  = $_POST['confirm_password'] ?? '';
        $role     = $_POST['role'] ?? '';

        if (!$username || !$password || !$confirm || !$role) {
            $error = "All fields are required.";
        }
        elseif (strlen($password) < 6) {
            $error = "Password must be at least 6 characters long.";
        }
        elseif ($password !== $confirm) {
            $error = "Passwords do not match.";
        }
        else {
            $check = $pdo->prepare("SELECT id FROM users WHERE username = ?");
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
<div>
    <h2>Create Account</h2>
</div>
<form method="POST" class="form">


    <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <label>Username</label>
    <input name="username" value="<?= htmlspecialchars($username) ?>" required>

    <label>Password</label>
    <input type="password" name="password" required minlength="6">

    <label>Confirm Password</label>
    <input type="password" name="confirm_password" required minlength="6">

    <label>Register As</label>
    <select name="role" required>
        <option value="">-- Select Role --</option>
        <option value="admin">Admin (Department Staff)</option>
        <option value="user">Student / Teacher</option>
    </select>

    <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
    <button type="submit">Create Account</button>
</form>

<?php require '../includes/footer.php'; ?>
