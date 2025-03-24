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
        $error_message = 'Por favor, preencha todos os campos.';
    } else {
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
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2980b9;
            --light-bg: #f8f9fa;
            --card-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        body {
            background-color: var(--light-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .form-container {
            max-width: 600px;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            border-radius: 10px;
            box-shadow: var(--card-shadow);
        }
        
        .form-header {
            color: var(--primary-color);
            text-align: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #eee;
        }
        
        .form-label {
            font-weight: 500;
            color: #555;
        }
        
        .btn-primary-custom {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            transition: all 0.3s;
        }
        
        .btn-primary-custom:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        .input-group-text {
            background-color: #e9ecef;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="form-container">
            <div class="form-header">
                <h2><i class="bi bi-pencil-square"></i> Atualizar Conta</h2>
                <p class="text-muted">Modifique os dados da conta bancária</p>
            </div>
            
            <!-- Mensagens de feedback -->
            <?php if (isset($success_message)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i><?= $success_message ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            
            <?php if (isset($error_message)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i><?= $error_message ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            
            <!-- Formulário de atualização -->
            <form action="atualizar_conta.php?id=<?= $id_conta ?>" method="POST">
                <div class="mb-4">
                    <label for="nome_conta" class="form-label">Nome da Conta</label>
                    <input type="text" class="form-control form-control-lg" id="nome_conta" name="nome_conta" 
                           value="<?= htmlspecialchars($conta['nome_conta']) ?>" required>
                </div>
                
                <div class="mb-4">
                    <label for="saldo" class="form-label">Saldo Disponível</label>
                    <div class="input-group">
                        <span class="input-group-text">R$</span>
                        <input type="number" step="0.01" class="form-control form-control-lg" id="saldo" name="saldo" 
                               value="<?= htmlspecialchars($conta['saldo']) ?>" required>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label for="tipo" class="form-label">Tipo de Conta</label>
                    <select class="form-select form-select-lg" id="tipo" name="tipo" required>
                        <option value="bancária" <?= $conta['tipo'] === 'bancária' ? 'selected' : '' ?>>Conta Bancária</option>
                        <option value="carteira digital" <?= $conta['tipo'] === 'carteira digital' ? 'selected' : '' ?>>Carteira Digital</option>
                        <option value="outro" <?= $conta['tipo'] === 'outro' ? 'selected' : '' ?>>Outro Tipo</option>
                    </select>
                </div>
                
                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-primary-custom btn-lg">
                        <i class="bi bi-check-lg me-2"></i>Atualizar Conta
                    </button>
                    <a href="javascript:history.back()" class="btn btn-outline-secondary btn-lg">
                        <i class="bi bi-arrow-left me-2"></i>Voltar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>