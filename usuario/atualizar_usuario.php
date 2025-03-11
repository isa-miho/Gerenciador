<?php
// Conectar ao banco de dados
require_once '../connect.php';

// Verificar se o ID do usuário foi passado na URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('ID do usuário inválido.');
}

$id_usuario = $_GET['id']; // Recebendo o ID do usuário para editar

// Buscar os dados do usuário
$sql = "SELECT * FROM usuario WHERE id_usuario = :id_usuario";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id_usuario', $id_usuario);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    die('Usuário não encontrado.');
}

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capturar os dados do formulário
    $id_usuario = $_POST['id_usuario'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Validar se os campos obrigatórios estão preenchidos
    if (empty($nome) || empty($email)) {
        die('Nome e e-mail são obrigatórios.');
    }

    // Se o usuário optou por mudar a senha, vamos processar a nova senha
    if (!empty($senha)) {
        // Criptografar a senha (se não for deixada em branco)
        $senha_hash = password_hash($senha, PASSWORD_BCRYPT);
        $sql = "UPDATE usuario SET nome = :nome, email = :email, senha = :senha WHERE id_usuario = :id_usuario";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':senha', $senha_hash);
    } else {
        // Caso a senha não tenha sido alterada, não atualizamos o campo de senha
        $sql = "UPDATE usuario SET nome = :nome, email = :email WHERE id_usuario = :id_usuario";
        $stmt = $pdo->prepare($sql);
    }

    // Associar os outros parâmetros da consulta
    $stmt->bindParam(':id_usuario', $id_usuario);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);

    // Tentar executar a query
    try {
        $stmt->execute();
        // Redirecionar para outra página após a atualização
        header('Location: listar_usuario.php');
        exit;
    } catch (PDOException $e) {
        echo "Erro ao atualizar usuário: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Usuário</title>
</head>
<body>
    <h1>Atualizar Usuário</h1>
    <div class="navigation">
        <a href="../index.php">Voltar ao Dashboard</a>
        <a href="listar_usuario.php">Listar Usuários</a>
    </div>
    <form action="atualizar_usuario.php?id=<?= $id_usuario ?>" method="POST">
        <input type="hidden" name="id_usuario" value="<?= $usuario['id_usuario']; ?>">

        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" value="<?= htmlspecialchars($usuario['nome']); ?>" required>

        <label for="email">E-mail:</label>
        <input type="email" name="email" id="email" value="<?= htmlspecialchars($usuario['email']); ?>" required>

        <label for="senha">Senha:</label>
        <input type="password" name="senha" id="senha" placeholder="Deixe em branco para manter a senha atual">

        <button type="submit">Atualizar</button>
    </form>
</body>
</html>