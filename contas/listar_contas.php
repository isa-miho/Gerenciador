<?php
// Conectar ao banco de dados
require_once '../connect.php';

// Buscar todas as contas
$sql = "SELECT * FROM contas";
$stmt = $pdo->query($sql);
$contas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Contas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
    <h1>Listar Contas</h1>
    <div class="navigation">
        <a href="../index.php">Voltar ao Dashboard</a>
        <a href="criar_conta.php">Criar Nova Conta</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>ID Usuário</th>
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
                    <td><?= htmlspecialchars($conta['saldo']) ?></td>
                    <td><?= htmlspecialchars($conta['tipo']) ?></td>
                    <td>
                        <a href="atualizar_conta.php?id=<?= $conta['id_conta'] ?>">Editar</a>
                        <a href="deletar_conta.php?id=<?= $conta['id_conta'] ?>" onclick="return confirm('Tem certeza?')">Deletar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>