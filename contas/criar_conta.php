<?php
// Conectar ao banco de dados
require_once '../connect.php';

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capturar os dados do formulário
    $id_usuario = $_POST['id_usuario'];
    $nome_conta = $_POST['nome_conta'];
    $saldo = $_POST['saldo'];
    $tipo = $_POST['tipo'];

    // Validar os dados
    if (empty($id_usuario) || empty($nome_conta) || empty($saldo) || empty($tipo)) {
        die('Por favor, preencha todos os campos.');
    }

    // Preparar a query para inserir a conta
    $sql = "INSERT INTO contas (id_usuario, nome_conta, saldo, tipo) 
            VALUES (:id_usuario, :nome_conta, :saldo, :tipo)";
    $stmt = $pdo->prepare($sql);

    // Associar os parâmetros com os valores
    $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
    $stmt->bindParam(':nome_conta', $nome_conta);
    $stmt->bindParam(':saldo', $saldo);
    $stmt->bindParam(':tipo', $tipo);

    // Executar a query
    try {
        $stmt->execute();
        echo "Conta criada com sucesso!";
    } catch (PDOException $e) {
        echo "Erro ao criar conta: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Conta</title>
</head>
<body>
    <h1>Criar Conta</h1>
    <form action="criar_conta.php" method="POST">
        <label for="id_usuario">ID do Usuário:</label>
        <input type="number" name="id_usuario" id="id_usuario" required>

        <label for="nome_conta">Nome da Conta:</label>
        <input type="text" name="nome_conta" id="nome_conta" required>

        <label for="saldo">Saldo:</label>
        <input type="number" step="0.01" name="saldo" id="saldo" required>

        <label for="tipo">Tipo:</label>
        <select name="tipo" id="tipo" required>
            <option value="bancária">Bancária</option>
            <option value="carteira digital">Carteira Digital</option>
            <option value="outro">Outro</option>
        </select>

        <button type="submit">Criar</button>
    </form>
</body>
</html>