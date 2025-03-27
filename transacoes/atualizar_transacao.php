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
        $error_message = 'Por favor, preencha todos os campos.';
    } else {
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
            $success_message = "Transação atualizada com sucesso!";
        } catch (PDOException $e) {
            $error_message = "Erro ao atualizar transação: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Transação</title>
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
                <h2><i class="bi bi-pencil-square"></i> Atualizar Transação</h2>
                <p class="text-muted">Modifique os dados da transação financeira</p>
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
            <form action="atualizar_transacao.php?id=<?= $id_transacao ?>" method="POST">
                <div class="mb-4">
                    <label for="descricao" class="form-label">Descrição</label>
                    <input type="text" class="form-control form-control-lg" id="descricao" name="descricao" 
                           value="<?= htmlspecialchars($transacao['descricao']) ?>" required>
                </div>
                
                <div class="mb-4">
                    <label for="valor" class="form-label">Valor</label>
                    <div class="input-group">
                        <span class="input-group-text">R$</span>
                        <input type="number" step="0.01" class="form-control form-control-lg" id="valor" name="valor" 
                               value="<?= htmlspecialchars($transacao['valor']) ?>" required>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label for="data_transacao" class="form-label">Data da Transação</label>
                    <input type="date" class="form-control form-control-lg" id="data_transacao" name="data_transacao" 
                           value="<?= htmlspecialchars($transacao['data_transacao']) ?>" required>
                </div>
                
                <div class="mb-4">
                    <label for="tipo" class="form-label">Tipo</label>
                    <select class="form-select form-select-lg" id="tipo" name="tipo" required>
                        <option value="despesa" <?= $transacao['tipo'] === 'despesa' ? 'selected' : '' ?>>Despesa</option>
                        <option value="receita" <?= $transacao['tipo'] === 'receita' ? 'selected' : '' ?>>Receita</option>
                    </select>
                </div>
                
                <div class="mb-4">
                    <label for="categoria" class="form-label">Categoria</label>
                    <input type="text" class="form-control form-control-lg" id="categoria" name="categoria" 
                           value="<?= htmlspecialchars($transacao['categoria']) ?>" required>
                </div>
                
                <div class="mb-4">
                    <label for="status_transacao" class="form-label">Status</label>
                    <select class="form-select form-select-lg" id="status_transacao" name="status_transacao" required>
                        <option value="pendente" <?= $transacao['status_transacao'] === 'pendente' ? 'selected' : '' ?>>Pendente</option>
                        <option value="concluída" <?= $transacao['status_transacao'] === 'concluída' ? 'selected' : '' ?>>Concluída</option>
                        <option value="cancelada" <?= $transacao['status_transacao'] === 'cancelada' ? 'selected' : '' ?>>Cancelada</option>
                    </select>
                </div>
                
                <div class="mb-4">
                    <label for="metodo_pagamento" class="form-label">Método de Pagamento</label>
                    <input type="text" class="form-control form-control-lg" id="metodo_pagamento" name="metodo_pagamento" 
                           value="<?= htmlspecialchars($transacao['metodo_pagamento']) ?>" required>
                </div>
                
                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-primary-custom btn-lg">
                        <i class="bi bi-check-lg me-2"></i>Atualizar Transação
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