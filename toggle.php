<?php
require_once __DIR__ . '/config.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id > 0) {
    $stmt = $pdo->prepare('SELECT concluida FROM tarefas WHERE id = :id');
    $stmt->execute([':id' => $id]);
    $atual = $stmt->fetchColumn();

    if ($atual === false) {
        header('Location: index.php');
        exit;
    }

    if ($atual == 0) {
        $sql = 'UPDATE tarefas
                SET concluida = 1,
                    data_conclusao = NOW()
                WHERE id = :id';
    } else {
        $sql = 'UPDATE tarefas
                SET concluida = 0,
                    data_conclusao = NULL
                WHERE id = :id';
    }

    $pdo->prepare($sql)->execute([':id' => $id]);
}

header('Location: index.php');
exit;
