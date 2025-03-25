<?php
// Conectar ao banco de dados
require_once '../connect.php';

// Buscar todas as contas
$sql = "SELECT * FROM contas ORDER BY nome_conta";
$stmt = $pdo->query($sql);
$contas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Contas</title>
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
        .badge-bancaria {
            background-color: #0d6efd;
        }
        .badge-digital {
            background-color: #6f42c1;
        }
        .badge-outro {
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
            <h1 class="mb-0">Lista de Contas</h1>
            <div>
                <a href="../index.php" class="btn btn-outline-secondary me-2">
                    <i class="bi bi-arrow-left"></i> Voltar
                </a>
                <a href="criar_conta.php" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Nova Conta
                </a>
            </div>
        </div>
        <div class="table-container">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>ID</th>
                            <th>Usuário</th>
                            <th>Nome da Conta</th>
                            <th>Saldo</th>
                            <th>Tipo</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($contas as $conta): ?>
                            <tr>
                                <td><?= htmlspecialchars($conta['id_conta']) ?></td>
                                <td><?= htmlspecialchars($conta['id_usuario']) ?></td>
                                <td><?= htmlspecialchars($conta['nome_conta']) ?></td>
                                <td>R$ <?= number_format($conta['saldo'], 2, ',', '.') ?></td>
                                <td>
                                    <?php 
                                    $badge_class = 'badge-outro';
                                    if ($conta['tipo'] === 'bancária') $badge_class = 'badge-bancaria';
                                    if ($conta['tipo'] === 'carteira digital') $badge_class = 'badge-digital';
                                    ?>
                                    <span class="badge <?= $badge_class ?>"><?= ucfirst($conta['tipo']) ?></span>
                                </td>
                                <td class="action-buttons">
                                    <a href="atualizar_conta.php?id=<?= $conta['id_conta'] ?>" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i> Editar
                                    </a>
                                    <a href="deletar_conta.php?id=<?= $conta['id_conta'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta conta?')">
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