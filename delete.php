<?php
require_once __DIR__ . '/config.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id > 0) {
    $stmt = $pdo->prepare('DELETE FROM tarefas WHERE id = :id');
    $stmt->execute([':id' => $id]);
}

header('Location: index.php');
exit;
