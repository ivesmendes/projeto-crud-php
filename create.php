<?php
require_once __DIR__ . '/config.php';
include   __DIR__ . '/includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $titulo    = trim($_POST['titulo'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');

    if ($titulo === '') {
        $erro = 'O título é obrigatório.';
    } else {
        $sql = 'INSERT INTO tarefas (titulo, descricao) VALUES (:titulo, :descricao)';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':titulo'    => $titulo,
            ':descricao' => $descricao,
        ]);

        header('Location: index.php');
        exit;
    }
}
?>

<h2>Nova Tarefa</h2>

<?php if (!empty($erro)): ?>
  <p style="color: red;"><?= htmlspecialchars($erro) ?></p>
<?php endif; ?>

<form action="create.php" method="post">
  <div>
    <label for="titulo">Título:</label><br>
    <input
      type="text"
      id="titulo"
      name="titulo"
      value="<?= isset($titulo) ? htmlspecialchars($titulo) : '' ?>"
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
    ><?= isset($descricao) ? htmlspecialchars($descricao) : '' ?></textarea>
  </div>
  <div style="margin-top: 1em;">
    <button type="submit">Salvar</button>
    <a href="index.php" style="margin-left: 1em;">Cancelar</a>
  </div>
</form>

<?php
include __DIR__ . '/includes/footer.php';
?>
