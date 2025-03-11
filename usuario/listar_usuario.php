<?php

// Iniciar a sessão para acessar mensagens de feedback
session_start();

// Exibir mensagem de feedback, se existir
if (isset($_SESSION['mensagem'])) {
    echo "<p>" . htmlspecialchars($_SESSION['mensagem']) . "</p>";
    unset($_SESSION['mensagem']); // Limpar a mensagem após exibição
}
// Incluir o arquivo de conexão
require_once '../connect.php';

try {
    // Preparar a consulta SQL para buscar todos os usuários
    $sql = "SELECT * FROM usuario"; // Certifique-se de que o nome da tabela está correto
    $stmt = $pdo->prepare($sql);

    // Executar a consulta
    $stmt->execute();

    // Buscar todos os usuários como um array associativo
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Tratar erros de banco de dados
    die("Erro ao buscar usuários: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listagem de Usuários</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 8px 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .actions {
            display: flex;
            gap: 10px;
        }

        .actions a {
            text-decoration: none;
            padding: 5px 10px;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
        }

        .actions a.delete {
            background-color: #f44336;
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

    <h1>Listagem de Usuários</h1>
    <div class="navigation">
    <a href="../index.php">Voltar ao Dashboard</a>
    <a href="criar_usuario.php">Criar Novo Usuário</a>
</div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Exibir os usuários na tabela
            if ($usuarios) {
                foreach ($usuarios as $usuario) {
                    echo "<tr>";
                    echo "<td>" . $usuario['id_usuario'] . "</td>";
                    echo "<td>" . htmlspecialchars($usuario['nome']) . "</td>";
                    echo "<td>" . htmlspecialchars($usuario['email']) . "</td>";
                    echo "<td class='actions'>
                            <a href='atualizar_usuario.php?id=" . $usuario['id_usuario'] . "'>Editar</a>
                            <a href='deletar_usuario.php?id=" . $usuario['id_usuario'] . "' class='delete' onclick='return confirm(\"Tem certeza que deseja excluir?\")'>Deletar</a>
                        </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Nenhum usuário encontrado.</td></tr>";
            }
            ?>
        </tbody>
    </table>

</body>
</html>