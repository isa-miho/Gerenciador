<?php
// Conectar ao banco de dados
require_once '../connect.php';

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capturar os dados do formulário
    $id_usuario = $_POST['id_usuario'];
    $descricao = $_POST['descricao'];
    $valor = $_POST['valor'];
    $data_transacao = $_POST['data_transacao'];
    $tipo = $_POST['tipo'];
    $categoria = $_POST['categoria'];
    $status_transacao = $_POST['status_transacao'];
    $metodo_pagamento = $_POST['metodo_pagamento'];

    // Validar os dados
    if (empty($id_usuario) || empty($descricao) || empty($valor) || empty($data_transacao) || empty($tipo) || empty($categoria) || empty($status_transacao) || empty($metodo_pagamento)) {
        die('Por favor, preencha todos os campos.');
    }

    // Preparar a query para inserir a transação
    $sql = "INSERT INTO transacoes (id_usuario, descricao, valor, data_transacao, tipo, categoria, status_transacao, metodo_pagamento) 
            VALUES (:id_usuario, :descricao, :valor, :data_transacao, :tipo, :categoria, :status_transacao, :metodo_pagamento)";
    $stmt = $pdo->prepare($sql);

    // Associar os parâmetros com os valores
    $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':valor', $valor);
    $stmt->bindParam(':data_transacao', $data_transacao);
    $stmt->bindParam(':tipo', $tipo);
    $stmt->bindParam(':categoria', $categoria);
    $stmt->bindParam(':status_transacao', $status_transacao);
    $stmt->bindParam(':metodo_pagamento', $metodo_pagamento);

    // Executar a query
    try {
        $stmt->execute();
        echo "Transação criada com sucesso!";
    } catch (PDOException $e) {
        echo "Erro ao criar transação: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Transação</title>
</head>
<body>
    <h1>Criar Transação</h1>
    <form action="criar_transacao.php" method="POST">
        <label for="id_usuario">ID do Usuário:</label>
        <input type="number" name="id_usuario" id="id_usuario" required>

        <label for="descricao">Descrição:</label>
        <input type="text" name="descricao" id="descricao" required>

        <label for="valor">Valor:</label>
        <input type="number" step="0.01" name="valor" id="valor" required>

        <label for="data_transacao">Data da Transação:</label>
        <input type="date" name="data_transacao" id="data_transacao" required>

        <label for="tipo">Tipo:</label>
        <select name="tipo" id="tipo" required>
            <option value="despesa">Despesa</option>
            <option value="receita">Receita</option>
        </select>

        <label for="categoria">Categoria:</label>
        <input type="text" name="categoria" id="categoria" required>

        <label for="status_transacao">Status:</label>
        <select name="status_transacao" id="status_transacao" required>
            <option value="pendente">Pendente</option>
            <option value="concluída">Concluída</option>
            <option value="cancelada">Cancelada</option>
        </select>

        <label for="metodo_pagamento">Método de Pagamento:</label>
        <input type="text" name="metodo_pagamento" id="metodo_pagamento" required>

        <button type="submit">Criar</button>
    </form>
</body>
</html>