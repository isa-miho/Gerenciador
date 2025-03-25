<?php
require_once '../connect.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    if (empty($nome) || empty($email) || empty($senha)) {
        die('Por favor, preencha todos os campos.');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die('E-mail inválido.');
    }

    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
    $sql = "INSERT INTO usuario (nome, email, senha) VALUES (:nome, :email, :senha)";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha_hash);
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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