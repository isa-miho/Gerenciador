<?php
// Iniciar a sessão para armazenar mensagens de feedback (opcional)
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Gerenciador Financeiro</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .menu {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }
        .menu a {
            text-decoration: none;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .menu a:hover {
            background-color: #45a049;
        }
        .feedback {
            text-align: center;
            margin-bottom: 20px;
            color: green;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Gerenciador Financeiro</h1>

        <!-- Exibir mensagens de feedback (opcional) -->
        <?php if (isset($_SESSION['mensagem'])): ?>
            <div class="feedback">
                <?= htmlspecialchars($_SESSION['mensagem']) ?>
            </div>
            <?php unset($_SESSION['mensagem']); ?>
        <?php endif; ?>

        <!-- Menu de Navegação -->
        <div class="menu">
            <a href="usuario/listar_usuario.php">Gerenciar Usuários</a>
            <a href="transacoes/listar_transacao.php">Gerenciar Transações</a>
            <a href="contas/listar_contas.php">Gerenciar Contas</a>
        </div>

        <!-- Conteúdo Principal (opcional) -->
        <div class="content">
            <h2>Bem-vindo ao Gerenciador Financeiro</h2>
            <p>Selecione uma das opções acima para começar.</p>
        </div>
    </div>
</body>
</html>