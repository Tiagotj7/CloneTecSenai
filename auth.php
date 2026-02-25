<?php
session_start();
require __DIR__ . '/config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

$stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username LIMIT 1');
$stmt->execute(['username' => $username]);
$user = $stmt->fetch();

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id']   = $user['id'];
    $_SESSION['user_name'] = $user['name'];
    $_SESSION['user_role'] = $user['role'];

    header('Location: dashboard.php');
    exit;
}

header('Location: login.php?error=1');
exit;