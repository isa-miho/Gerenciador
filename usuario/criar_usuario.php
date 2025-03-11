<?php
// Conectar ao banco de dados
require_once '../connect.php'; // Inclua o código de conexão com o banco de dados

// Verificar se os dados do formulário foram enviados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capturar os dados do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Validar os dados
    if (empty($nome) || empty($email) || empty($senha)) {
        die('Por favor, preencha todos os campos.');
    }

    // Validar formato do e-mail
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die('E-mail inválido.');
    }

    // Hash da senha
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Preparar a query para inserir os dados no banco de dados
    $sql = "INSERT INTO usuario (nome, email, senha) VALUES (:nome, :email, :senha)";

    try {
        // Preparar a execução da query
        $stmt = $pdo->prepare($sql);

        // Associar os parâmetros com os valores
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha_hash);

        // Executar a query
        $stmt->execute();

        echo "Usuário criado com sucesso!";
    } catch (PDOException $e) {
        echo "Erro ao criar usuário: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar usuário</title>
    <style>
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
    <h1>Criar Usuário</h1>

    <!-- Navigation Links -->
    <div class="navigation">
        <a href="../index.php">Voltar ao Dashboard</a>
        <a href="listar_usuario.php">Listar Usuários</a>
    </div>
    <form action="criar_usuario.php" method="POST">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" required>

        <label for="email">E-mail:</label>
        <input type="email" name="email" id="email" required>

        <label for="senha">Senha:</label>
        <input type="password" name="senha" id="senha" required>

        <button type="submit">Cadastrar</button>
    </form>
</body>
</html>