<?php
require 'db.php';
$message = '';

if ($_POST) {
    $stmt = $pdo->prepare("INSERT INTO participants (name, email, event_id) VALUES (?,?,?)");
    $success = $stmt->execute([
        $_POST['name'],
        $_POST['email'],
        $_POST['event_id']
    ]);

    if ($success) {
        $message = "Registered Successfully!";
    } else {
        $message = "Registration Failed. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Event Registration</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background: #f4f7f8;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .container {
        background: #fff;
        padding: 30px 40px;
        border-radius: 10px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        width: 350px;
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #333;
    }

    input[type="text"],
    input[type="email"],
    input[type="number"] {
        width: 100%;
        padding: 10px 15px;
        margin: 10px 0;
        border-radius: 5px;
        border: 1px solid #ccc;
        box-sizing: border-box;
        transition: border 0.3s;
    }

    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="number"]:focus {
        border-color: #007BFF;
        outline: none;
    }

    input[type="submit"] {
        width: 100%;
        padding: 12px;
        background: #007BFF;
        border: none;
        border-radius: 5px;
        color: #fff;
        font-size: 16px;
        cursor: pointer;
        transition: background 0.3s;
    }

    input[type="submit"]:hover {
        background: #0056b3;
    }

    .message {
        text-align: center;
        margin-top: 15px;
        color: green;
        font-weight: bold;
    }
</style>
</head>
<body>
<div class="container">
    <h2>Event Registration</h2>
    <form method="post" action="">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="number" name="event_id" placeholder="Event ID" required>
        <input type="submit" value="Register">
    </form>
    <?php if($message) echo "<div class='message'>$message</div>"; ?>
</div>
</body>

