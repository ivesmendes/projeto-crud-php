<?php
require_once __DIR__ . '/config.php';
include   __DIR__ . '/includes/header.php';

$f = $_GET['filter'] ?? 'all';
$allowed = ['all', 'pendentes', 'concluidas'];
if (!in_array($f, $allowed)) {
    $f = 'all';
}

switch ($f) {
    case 'pendentes':
        $where = 'WHERE concluida = 0';
        break;
    case 'concluidas':
        $where = 'WHERE concluida = 1';
        break;
    default:
        $where = '';
}

$sql = "
    SELECT
      id,
      titulo,
      criado_em,
      concluida,
      data_conclusao
    FROM tarefas
    $where
    ORDER BY criado_em DESC
";
$stmt = $pdo->query($sql);
$tarefas = $stmt->fetchAll();
?>

<h2>Lista de Tarefas</h2>

<p>
  <a href="index.php?filter=all"
     <?= $f === 'all' ? 'style="font-weight:bold;"' : '' ?>>Todas</a> |
  <a href="index.php?filter=pendentes"
     <?= $f === 'pendentes' ? 'style="font-weight:bold;"' : '' ?>>Pendentes</a> |
  <a href="index.php?filter=concluidas"
     <?= $f === 'concluidas' ? 'style="font-weight:bold;"' : '' ?>>Concluídas</a>
</p>

<div class="export-links">
  <a href="export_csv.php" class="btn-export csv">
    📄 CSV
  </a>
  <a href="export_pdf.php" class="btn-export pdf">
    🖨️ PDF
  </a>
</div>


<?php if (empty($tarefas)): ?>
  <p>Não há tarefas para exibir.</p>
<?php else: ?>
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Título</th>
        <th>Criado em</th>
        <th>Status</th>
        <th>Conclusão</th>
        <th>Ações</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($tarefas as $t): ?>
        <tr class="<?= $t['concluida'] ? 'completed' : '' ?>">
          <td><?= $t['id'] ?></td>
          <td><?= htmlspecialchars($t['titulo']) ?></td>
          <td><?= $t['criado_em'] ?></td>
          <td><?= $t['concluida'] ? 'Concluída' : 'Pendente' ?></td>
          <td class="data-conclusao">
            <?= $t['data_conclusao']
                ? date('d/m/Y H:i', strtotime($t['data_conclusao']))
                : '—' ?>
          </td>
          <td>
            <a href="toggle.php?id=<?= $t['id'] ?>">
              <?= $t['concluida'] ? 'Reabrir' : 'Concluir' ?>
            </a> |
            <a href="edit.php?id=<?= $t['id'] ?>">Editar</a> |
            <a href="delete.php?id=<?= $t['id'] ?>"
               onclick="return confirm('Excluir esta tarefa?')">
              Excluir
            </a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php endif; ?>

<?php
include __DIR__ . '/includes/footer.php';
?>
