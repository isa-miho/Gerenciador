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

    // Validar os dados
    if (empty($nome) || empty($email)) {
        $error_message = 'Por favor, preencha nome e email.';
    }
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
        $error_message = "Erro ao atualizar conta: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2980b9;
            --light-bg: #f8f9fa;
            --card-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        body {
            background-color: var(--light-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .form-container {
            max-width: 600px;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            border-radius: 10px;
            box-shadow: var(--card-shadow);
        }
        
        .form-header {
            color: var(--primary-color);
            text-align: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #eee;
        }
        
        .form-label {
            font-weight: 500;
            color: #555;
        }
        
        .btn-primary-custom {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            transition: all 0.3s;
        }
        
        .btn-primary-custom:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        .input-group-text {
            background-color: #e9ecef;
        }
    </style> 
</head>
<body>
    <div class="container py-5">
        <div class="form-container">
            <div class="form-header">
                <h2><i class="bi bi-pencil-square"></i> Atualizar Conta</h2>
                <p class="text-muted">Modifique os dados do usuário</p>
            </div>
                
            <!-- Mensagens de feedback -->
            <?php if (isset($success_message)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i><?= $success_message ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            
            <?php if (isset($error_message)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i><?= $error_message ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
    
            <form action="atualizar_usuario.php?id=<?= $id_usuario ?>" method="POST">
                <input type="hidden" name="id_usuario" value="<?= $usuario['id_usuario']; ?>">
                
                <div class="mb-4">
                    <label for="nome" class="form-label">Nome:</label>
                    <input type="text" name="nome" id="nome" class="form-control form-control-lg" value="<?= htmlspecialchars($usuario['nome']); ?>" required>
                </div>

                <div class="mb-4">
                    <label for="email" class="form-label">E-mail:</label>
                    <input type="email" name="email" id="email" class="form-control form-control-lg" value="<?= htmlspecialchars($usuario['email']); ?>" required>
                </div>

                <div class="mb-4">
                    <label for="senha" class="form-label">Senha:</label>
                    <input type="password" name="senha" id="senha" class="form-control form-control-lg" placeholder="Deixe em branco para manter a senha atual">
                </div>

                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-primary-custom btn-lg">
                        <i class="bi bi-check-lg me-2"></i>Atualizar Conta
                    </button>
                    <a href="javascript:history.back()" class="btn btn-outline-secondary btn-lg">
                        <i class="bi bi-arrow-left me-2"></i>Voltar
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>