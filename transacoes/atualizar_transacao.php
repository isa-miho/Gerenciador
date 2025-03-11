<?php
// Conectar ao banco de dados
require_once '../connect.php';

// Verificar se o ID da transação foi passado
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('ID da transação inválido.');
}

$id_transacao = $_GET['id'];

// Buscar os dados da transação
$sql = "SELECT * FROM transacoes WHERE id_transacao = :id_transacao";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id_transacao', $id_transacao, PDO::PARAM_INT);
$stmt->execute();
$transacao = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$transacao) {
    die('Transação não encontrada.');
}

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capturar os dados do formulário
    $descricao = $_POST['descricao'];
    $valor = $_POST['valor'];
    $data_transacao = $_POST['data_transacao'];
    $tipo = $_POST['tipo'];
    $categoria = $_POST['categoria'];
    $status_transacao = $_POST['status_transacao'];
    $metodo_pagamento = $_POST['metodo_pagamento'];

    // Validar os dados
    if (empty($descricao) || empty($valor) || empty($data_transacao) || empty($tipo) || empty($categoria) || empty($status_transacao) || empty($metodo_pagamento)) {
        die('Por favor, preencha todos os campos.');
    }

    // Atualizar a transação
    $sql = "UPDATE transacoes SET descricao = :descricao, valor = :valor, data_transacao = :data_transacao, tipo = :tipo, categoria = :categoria, status_transacao = :status_transacao, metodo_pagamento = :metodo_pagamento 
            WHERE id_transacao = :id_transacao";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':valor', $valor);
    $stmt->bindParam(':data_transacao', $data_transacao);
    $stmt->bindParam(':tipo', $tipo);
    $stmt->bindParam(':categoria', $categoria);
    $stmt->bindParam(':status_transacao', $status_transacao);
    $stmt->bindParam(':metodo_pagamento', $metodo_pagamento);
    $stmt->bindParam(':id_transacao', $id_transacao, PDO::PARAM_INT);

    try {
        $stmt->execute();
        echo "Transação atualizada com sucesso!";
    } catch (PDOException $e) {
        echo "Erro ao atualizar transação: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Transação</title>
</head>
<body>
    <h1>Atualizar Transação</h1>
    <form action="atualizar_transacao.php?id=<?= $id_transacao ?>" method="POST">
        <label for="descricao">Descrição:</label>
        <input type="text" name="descricao" id="descricao" value="<?= htmlspecialchars($transacao['descricao']) ?>" required>

        <label for="valor">Valor:</label>
        <input type="number" step="0.01" name="valor" id="valor" value="<?= htmlspecialchars($transacao['valor']) ?>" required>

        <label for="data_transacao">Data:</label>
        <input type="date" name="data_transacao" id="data_transacao" value="<?= htmlspecialchars($transacao['data_transacao']) ?>" required>

        <label for="tipo">Tipo:</label>
        <select name="tipo" id="tipo" required>
            <option value="despesa" <?= $transacao['tipo'] === 'despesa' ? 'selected' : '' ?>>Despesa</option>
            <option value="receita" <?= $transacao['tipo'] === 'receita' ? 'selected' : '' ?>>Receita</option>
        </select>

        <label for="categoria">Categoria:</label>
        <input type="text" name="categoria" id="categoria" value="<?= htmlspecialchars($transacao['categoria']) ?>" required>

        <label for="status_transacao">Status:</label>
        <select name="status_transacao" id="status_transacao" required>
            <option value="pendente" <?= $transacao['status_transacao'] === 'pendente' ? 'selected' : '' ?>>Pendente</option>
            <option value="concluída" <?= $transacao['status_transacao'] === 'concluída' ? 'selected' : '' ?>>Concluída</option>
            <option value="cancelada" <?= $transacao['status_transacao'] === 'cancelada' ? 'selected' : '' ?>>Cancelada</option>
        </select>

        <label for="metodo_pagamento">Método de Pagamento:</label>
        <input type="text" name="metodo_pagamento" id="metodo_pagamento" value="<?= htmlspecialchars($transacao['metodo_pagamento']) ?>" required>

        <button type="submit">Atualizar</button>
    </form>
</body>
</html>