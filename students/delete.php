<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}

require __DIR__ . '/../config/database.php';

$id = $_GET['id'] ?? '';
if ($id === '' || !ctype_digit($id)) {
    header('Location: list.php');
    exit;
}

$stmt = $pdo->prepare("DELETE FROM students WHERE id = :id");
$stmt->execute(['id' => $id]);

header('Location: list.php');
exit;