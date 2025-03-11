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
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        .navigation {
            margin-bottom: 20px;
        }
        .navigation a {
            text-decoration: none;
            padding: 5px 10px;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
            margin-right: 10px;
        }
        .navigation a:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Listar Transações</h1>
    <div class="navigation">
        <a href="../index.php">Voltar ao Dashboard</a>
        <a href="criar_transacao.php">Criar Nova Transação</a>
    </div>

    <table>
        <thead>
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
                    <td><?= htmlspecialchars($transacao['status_transacao']) ?></td>
                    <td><?= htmlspecialchars($transacao['metodo_pagamento']) ?></td>
                    <td>
                        <a href="atualizar_transacao.php?id=<?= $transacao['id_transacao'] ?>">Editar</a>
                        <a href="deletar_transacao.php?id=<?= $transacao['id_transacao'] ?>" onclick="return confirm('Tem certeza?')">Deletar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>