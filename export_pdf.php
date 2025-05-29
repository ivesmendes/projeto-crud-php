<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/fpdf/fpdf.php';

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);

// Cabeçalho e larguras
$w = [10, 70, 30, 20, 40];
$header = ['ID', 'Título', 'Criado em', 'OK?', 'Conclusão'];
foreach ($header as $i => $col) {
    $pdf->Cell($w[$i], 8, utf8_decode($col), 1, 0, 'C');
}
$pdf->Ln();

// Dados
$pdf->SetFont('Arial','',10);
$stmt = $pdo->query('SELECT id, titulo, criado_em, concluida, data_conclusao FROM tarefas ORDER BY criado_em DESC');
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $pdf->Cell($w[0], 6, $row['id'], 1);
    // Título com utf8_decode e truncamento
    $tit = $row['titulo'];
    if (strlen($tit) > 40) {
      $tit = substr($tit, 0, 37).'...';
    }
    $pdf->Cell($w[1], 6, utf8_decode($tit), 1);
    // Data de criação
    $pdf->Cell($w[2], 6, date('d/m/Y', strtotime($row['criado_em'])), 1);
    // Status “Sim” / “Não”
    $status = $row['concluida'] ? 'Sim' : 'Não';
    $pdf->Cell($w[3], 6, utf8_decode($status), 1, 0, 'C');
    // Data de conclusão formatada
    $concl = $row['data_conclusao']
      ? date('d/m/Y H:i', strtotime($row['data_conclusao']))
      : '';
    $pdf->Cell($w[4], 6, utf8_decode($concl), 1);
    $pdf->Ln();
}

$pdf->Output('D', 'tarefas.pdf');
exit;
