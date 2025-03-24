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
            $success_message = "Conta atualizada com sucesso!";
        } catch (PDOException $e) {
            $error_message = "Erro ao atualizar conta: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Conta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }
        .form-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .form-title {
            color: #0d6efd;
            margin-bottom: 25px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h1 class="form-title">Atualizar Conta</h1>
            
            <?php if (isset($success_message)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= $success_message ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            
            <?php if (isset($error_message)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= $error_message ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            
            <form action="atualizar_conta.php?id=<?= $id_conta ?>" method="POST">
                <div class="mb-3">
                    <label for="nome_conta" class="form-label">Nome da Conta</label>
                    <input type="text" class="form-control" id="nome_conta" name="nome_conta" 
                           value="<?= htmlspecialchars($conta['nome_conta']) ?>" required>
                </div>
                
                <div class="mb-3">
                    <label for="saldo" class="form-label">Saldo</label>
                    <div class="input-group">
                        <span class="input-group-text">R$</span>
                        <input type="number" step="0.01" class="form-control" id="saldo" name="saldo" 
                               value="<?= htmlspecialchars($conta['saldo']) ?>" required>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label for="tipo" class="form-label">Tipo de Conta</label>
                    <select class="form-select" id="tipo" name="tipo" required>
                        <option value="bancária" <?= $conta['tipo'] === 'bancária' ? 'selected' : '' ?>>Bancária</option>
                        <option value="carteira digital" <?= $conta['tipo'] === 'carteira digital' ? 'selected' : '' ?>>Carteira Digital</option>
                        <option value="outro" <?= $conta['tipo'] === 'outro' ? 'selected' : '' ?>>Outro</option>
                    </select>
                </div>
                
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">Atualizar Conta</button>
                    <a href="javascript:history.back()" class="btn btn-outline-secondary">Voltar</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>