<?php
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
            background-color: #f5f5f5;
            color: #333;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 30px;
        }
        
        .menu {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-bottom: 30px;
        }
        
        .menu a {
            text-decoration: none;
            padding: 15px;
            background-color: #3498db;
            color: white;
            border-radius: 6px;
            text-align: center;
            font-weight: bold;
        }
        
        .menu a:hover {
            background-color: #2980b9;
        }
        
        .feedback {
            text-align: center;
            margin-bottom: 20px;
            padding: 10px;
            background-color: #d4edda;
            color: #155724;
            border-radius: 4px;
        }
        
        .content {
            text-align: center;
            padding: 20px 0;
        }
        
        @media (min-width: 600px) {
            .menu {
                flex-direction: row;
                justify-content: center;
            }
            
            .menu a {
                width: 200px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Gerenciador Financeiro</h1>

        <?php if (isset($_SESSION['mensagem'])): ?>
            <div class="feedback">
                <?= htmlspecialchars($_SESSION['mensagem']) ?>
            </div>
            <?php unset($_SESSION['mensagem']); ?>
        <?php endif; ?>

        <div class="menu">
            <a href="usuario/listar_usuario.php">Usuários</a>
            <a href="transacoes/listar_transacao.php">Transações</a>
            <a href="contas/listar_contas.php">Contas</a>
        </div>

        <div class="content">
            <p>Selecione uma opção acima para começar.</p>
        </div>
    </div>
</body>
</html>