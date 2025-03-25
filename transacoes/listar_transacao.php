<?php
// Conectar ao banco de dados
require_once '../connect.php';

// Buscar todas as transações
$sql = "SELECT * FROM transacoes";
$stmt = $pdo->query($sql);
$transacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Transações</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }
        .table-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            padding: 20px;
            margin-top: 20px;
        }
        .badge-concluída {
            background-color: #0d6efd;
        }
        .badge-cancelada {
            background-color: #6f42c1;
        }
        .badge-pendente {
            background-color: #fd7e14;
        }
        .action-buttons a {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Lista de Transações</h1>
            <div>
                <a href="../index.php" class="btn btn-outline-secondary me-2">
                    <i class="bi bi-arrow-left"></i> Voltar ao Dashboard
                </a>
                <a href="criar_transacao.php" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Nova Transação
                </a>
            </div>
        </div>
        <div class="table-container">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>ID</th>
                            <th>ID Usuário</th>
                            <th>Descrição</th>
                            <th>Valor</th>
                            <th>Data</th>
                            <th>Tipo</th>
                            <th>Categoria</th>
                            <th>Status</th>
                            <th>Método de Pagamento</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($transacoes as $transacao): ?>
                            <tr>
                                <td><?= htmlspecialchars($transacao['id_transacao']) ?></td>
                                <td><?= htmlspecialchars($transacao['id_usuario']) ?></td>
                                <td><?= htmlspecialchars($transacao['descricao']) ?></td>
                                <td><?= htmlspecialchars($transacao['valor']) ?></td>
                                <td><?= htmlspecialchars($transacao['data_transacao']) ?></td>
                                <td><?= htmlspecialchars($transacao['tipo']) ?></td>
                                <td><?= htmlspecialchars($transacao['categoria']) ?></td>
                                <td>
                                    <?php
                                    $badge_class = 'badge-pendente';
                                    if ($transacao['status_transacao'] === 'concluída') $badge_class = 'badge-concluída';
                                    if ($transacao['status_transacao'] === 'cancelada') $badge_class = 'badge-cancelada';
                                    ?>
                                    <span class="badge <?= $badge_class ?>"><?= ucfirst($transacao['status_transacao']) ?></span>
                                </td>
                                <td><?= htmlspecialchars($transacao['metodo_pagamento']) ?></td>
                                <td class="action-buttons">
                                    <a href="atualizar_transacao.php?id=<?= $transacao['id_transacao'] ?>" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i> Editar
                                    </a>
                                    <a href="deletar_transacao.php?id=<?= $transacao['id_transacao'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta conta?')">
                                        <i class="bi bi-trash"></i> Excluir
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>