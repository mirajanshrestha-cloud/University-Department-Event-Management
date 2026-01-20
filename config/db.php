<?php
$host = "localhost";
$dbname = "event_management";
$user = "root";
$pass = "";
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
