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
        $error_message = 'Por favor, preencha todos os campos.';
    } else {
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
            $success_message = "Conta criada com sucesso!";
            // Limpar os campos do formulário após o sucesso
            $id_usuario = $nome_conta = $saldo = $tipo = '';
        } catch (PDOException $e) {
            $error_message = "Erro ao criar conta: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Conta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }
        .form-container {
            max-width: 600px;
            margin: 30px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .form-title {
            color: #0d6efd;
            margin-bottom: 25px;
            text-align: center;
            font-weight: 600;
        }
        .btn-submit {
            padding: 10px 20px;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h1 class="form-title">Criar Nova Conta</h1>
            
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
            
            <form action="criar_conta.php" method="POST">
                <div class="mb-3">
                    <label for="id_usuario" class="form-label">ID do Usuário</label>
                    <input type="number" class="form-control" id="id_usuario" name="id_usuario" 
                           value="<?= isset($id_usuario) ? htmlspecialchars($id_usuario) : '' ?>" required>
                </div>
                
                <div class="mb-3">
                    <label for="nome_conta" class="form-label">Nome da Conta</label>
                    <input type="text" class="form-control" id="nome_conta" name="nome_conta" 
                           value="<?= isset($nome_conta) ? htmlspecialchars($nome_conta) : '' ?>" required>
                </div>
                
                <div class="mb-3">
                    <label for="saldo" class="form-label">Saldo Inicial</label>
                    <div class="input-group">
                        <span class="input-group-text">R$</span>
                        <input type="number" step="0.01" class="form-control" id="saldo" name="saldo" 
                               value="<?= isset($saldo) ? htmlspecialchars($saldo) : '' ?>" required>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label for="tipo" class="form-label">Tipo de Conta</label>
                    <select class="form-select" id="tipo" name="tipo" required>
                        <option value="" disabled selected>Selecione o tipo</option>
                        <option value="bancária" <?= (isset($tipo) && $tipo === 'bancária') ? 'selected' : '' ?>>Bancária</option>
                        <option value="carteira digital" <?= (isset($tipo) && $tipo === 'carteira digital') ? 'selected' : '' ?>>Carteira Digital</option>
                        <option value="outro" <?= (isset($tipo) && $tipo === 'outro') ? 'selected' : '' ?>>Outro</option>
                    </select>
                </div>
                
                <div class="d-grid gap-3">
                    <button type="submit" class="btn btn-primary btn-submit">Criar Conta</button>
                    <a href="javascript:history.back()" class="btn btn-outline-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>