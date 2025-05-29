<?php
require_once __DIR__ . '/config.php';

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="tarefas.csv"');

$output = fopen('php://output', 'w');
fputcsv($output, ['ID', 'Título', 'Descrição', 'Criado em', 'Concluída', 'Data de Conclusão']);

$stmt = $pdo->query('SELECT * FROM tarefas ORDER BY criado_em DESC');
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    fputcsv($output, [
        $row['id'],
        $row['titulo'],
        $row['descricao'],
        $row['criado_em'],
        $row['concluida'] ? 'Sim' : 'Não',
        $row['data_conclusao'] ?? ''
    ]);
}

fclose($output);
exit;
