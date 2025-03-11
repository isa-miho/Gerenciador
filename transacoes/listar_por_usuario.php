<?php
// Conectar ao banco de dados
require_once '../connect.php';

// Verificar se o ID do usuário foi passado
if (!isset($_GET['id_usuario']) || !is_numeric($_GET['id_usuario'])) {
    die('ID do usuário inválido.');
}

$id_usuario = $_GET['id_usuario'];

// Buscar transações do usuário
$sql = "SELECT * FROM transacoes WHERE id_usuario = :id_usuario";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
$stmt->execute();
$transacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transações do Usuário</title>
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
    </style>
</head>
<body>
    <h1>Transações do Usuário</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Descrição</th>
                <th>Valor</th>
                <th>Data</th>
                <th>Tipo</th>
                <th>Categoria</th>
                <th>Status</th>
                <th>Método de Pagamento</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($transacoes as $transacao): ?>
                <tr>
                    <td><?= htmlspecialchars($transacao['id_transacao']) ?></td>
                    <td><?= htmlspecialchars($transacao['descricao']) ?></td>
                    <td><?= htmlspecialchars($transacao['valor']) ?></td>
                    <td><?= htmlspecialchars($transacao['data_transacao']) ?></td>
                    <td><?= htmlspecialchars($transacao['tipo']) ?></td>
                    <td><?= htmlspecialchars($transacao['categoria']) ?></td>
                    <td><?= htmlspecialchars($transacao['status_transacao']) ?></td>
                    <td><?= htmlspecialchars($transacao['metodo_pagamento']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>