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
        $error_message = 'Por favor, preencha todos os campos.';
    } else {
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
            $success_message = "Transação criada com sucesso!";
            // Limpar os campos do formulário após o sucesso
            $id_usuario = $descricao = $valor = $data_transacao = $tipo = $categoria = $status_transacao = $metodo_pagamento = '';
        } catch (PDOException $e) {
            $error_message = "Erro ao criar transação: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Transação</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
            <h1 class="form-title">Criar Transação</h1>
            
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

            <form action="criar_transacao.php" method="POST">
                <div class="mb-3">
                    <label for="id_usuario" class="form-label">ID do Usuário</label>
                    <input type="number" class="form-control" id="id_usuario" name="id_usuario" 
                           value="<?= isset($id_usuario) ? htmlspecialchars($id_usuario) : '' ?>" required>
                </div>
                
                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição</label>
                    <input type="text" class="form-control" id="descricao" name="descricao" 
                           value="<?= isset($descricao) ? htmlspecialchars($descricao) : '' ?>" required>
                </div>

                <div class="mb-3">
                    <label for="valor" class="form-label">Valor</label>
                    <div class="input-group">
                        <span class="input-group-text">R$</span>
                        <input type="number" step="0.01" class="form-control" id="valor" name="valor" 
                               value="<?= isset($valor) ? htmlspecialchars($valor) : '' ?>" required>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="data_transacao" class="form-label">Data da Transação</label>
                    <input type="date" class="form-control" id="data_transacao" name="data_transacao" 
                           value="<?= isset($data_transacao) ? htmlspecialchars($data_transacao) : '' ?>" required>
                </div>
                
                <div class="mb-3">
                    <label for="tipo" class="form-label">Tipo</label>
                    <select class="form-select" id="tipo" name="tipo" required>
                        <option value="despesa" <?= (isset($tipo) && $tipo === 'despesa') ? 'selected' : '' ?>>Despesa</option>
                        <option value="receita" <?= (isset($tipo) && $tipo === 'receita') ? 'selected' : '' ?>>Receita</option>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label for="categoria" class="form-label">Categoria</label>
                    <input type="text" class="form-control" id="categoria" name="categoria" 
                           value="<?= isset($categoria) ? htmlspecialchars($categoria) : '' ?>" required>
                </div>
                
                <div class="mb-3">
                    <label for="status_transacao" class="form-label">Status</label>
                    <select class="form-select" id="status_transacao" name="status_transacao" required>
                        <option value="pendente" <?= (isset($status_transacao) && $status_transacao === 'pendente') ? 'selected' : '' ?>>Pendente</option>
                        <option value="concluída" <?= (isset($status_transacao) && $status_transacao === 'concluída') ? 'selected' : '' ?>>Concluída</option>
                        <option value="cancelada" <?= (isset($status_transacao) && $status_transacao === 'cancelada') ? 'selected' : '' ?>>Cancelada</option>
                    </select>
                </div>
                
                <div class="mb-4">
                    <label for="metodo_pagamento" class="form-label">Método de Pagamento</label>
                    <input type="text" class="form-control" id="metodo_pagamento" name="metodo_pagamento" 
                           value="<?= isset($metodo_pagamento) ? htmlspecialchars($metodo_pagamento) : '' ?>" required>
                </div>
                
                <div class="d-grid gap-3">
                    <button type="submit" class="btn btn-primary btn-submit">Nova transação</button>
                    <a href="javascript:history.back()" class="btn btn-outline-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>