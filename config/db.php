<?php
$host = "localhost";
$dbname = "np03cs4a240235";
$user = "np03cs4a240235";
$pass = "qhtQbymU44";
session_start();

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=UTF8",
        $user,
        $pass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    die("Database connection failed");
}
