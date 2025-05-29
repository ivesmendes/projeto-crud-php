<?php
require_once __DIR__ . '/config.php';
include   __DIR__ . '/includes/header.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
    header('Location: index.php');
    exit;
}

$sql = 'SELECT * FROM tarefas WHERE id = :id';
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id]);
$tarefa = $stmt->fetch();

if (!$tarefa) {
    echo '<p>Tarefa não encontrada.</p>';
    include __DIR__ . '/includes/footer.php';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo    = trim($_POST['titulo'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');

    if ($titulo === '') {
        $erro = 'O título não pode ficar em branco.';
    } else {
        $sql = 'UPDATE tarefas
                SET titulo = :titulo, descricao = :descricao
                WHERE id = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':titulo'    => $titulo,
            ':descricao' => $descricao,
            ':id'        => $id,
        ]);

        header('Location: index.php');
        exit;
    }
}
?>

<h2>Editar Tarefa #<?= htmlspecialchars($tarefa['id']) ?></h2>

<?php if (!empty($erro)): ?>
  <p style="color: red;"><?= htmlspecialchars($erro) ?></p>
<?php endif; ?>

<form action="edit.php?id=<?= $tarefa['id'] ?>" method="post">
  <div>
    <label for="titulo">Título:</label><br>
    <input
      type="text"
      id="titulo"
      name="titulo"
      value="<?= htmlspecialchars($_POST['titulo'] ?? $tarefa['titulo']) ?>"
      required
      autofocus
    >
  </div>
  <div style="margin-top: 1em;">
    <label for="descricao">Descrição:</label><br>
    <textarea
      id="descricao"
      name="descricao"
      rows="5"
    ><?= htmlspecialchars($_POST['descricao'] ?? $tarefa['descricao']) ?></textarea>
  </div>
  <div style="margin-top: 1em;">
    <button type="submit">Atualizar</button>
    <a href="index.php" style="margin-left: 1em;">Cancelar</a>
  </div>
</form>

<?php
include __DIR__ . '/includes/footer.php';
?>
