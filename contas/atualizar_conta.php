<?php
// Conectar ao banco de dados
require_once '../connect.php';

// Verificar se o ID da conta foi passado
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('ID da conta inválido.');
}

$id_conta = $_GET['id'];

// Buscar os dados da conta
$sql = "SELECT * FROM contas WHERE id_conta = :id_conta";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id_conta', $id_conta, PDO::PARAM_INT);
$stmt->execute();
$conta = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$conta) {
    die('Conta não encontrada.');
}

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capturar os dados do formulário
    $nome_conta = $_POST['nome_conta'];
    $saldo = $_POST['saldo'];
    $tipo = $_POST['tipo'];

    // Validar os dados
    if (empty($nome_conta) || empty($saldo) || empty($tipo)) {
        die('Por favor, preencha todos os campos.');
    }

    // Atualizar a conta
    $sql = "UPDATE contas SET nome_conta = :nome_conta, saldo = :saldo, tipo = :tipo 
            WHERE id_conta = :id_conta";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome_conta', $nome_conta);
    $stmt->bindParam(':saldo', $saldo);
    $stmt->bindParam(':tipo', $tipo);
    $stmt->bindParam(':id_conta', $id_conta, PDO::PARAM_INT);

    try {
        $stmt->execute();
        echo "Conta atualizada com sucesso!";
    } catch (PDOException $e) {
        echo "Erro ao atualizar conta: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Conta</title>
</head>
<body>
    <h1>Atualizar Conta</h1>
    <form action="atualizar_conta.php?id=<?= $id_conta ?>" method="POST">
        <label for="nome_conta">Nome da Conta:</label>
        <input type="text" name="nome_conta" id="nome_conta" value="<?= htmlspecialchars($conta['nome_conta']) ?>" required>

        <label for="saldo">Saldo:</label>
        <input type="number" step="0.01" name="saldo" id="saldo" value="<?= htmlspecialchars($conta['saldo']) ?>" required>

        <label for="tipo">Tipo:</label>
        <select name="tipo" id="tipo" required>
            <option value="bancária" <?= $conta['tipo'] === 'bancária' ? 'selected' : '' ?>>Bancária</option>
            <option value="carteira digital" <?= $conta['tipo'] === 'carteira digital' ? 'selected' : '' ?>>Carteira Digital</option>
            <option value="outro" <?= $conta['tipo'] === 'outro' ? 'selected' : '' ?>>Outro</option>
        </select>

        <button type="submit">Atualizar</button>
    </form>
</body>
</html>