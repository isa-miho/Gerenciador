<?php
// Iniciar a sessão para armazenar mensagens de feedback
session_start();

// Conectar ao banco de dados
require_once '../connect.php';

// Verificar se o ID foi passado pela URL e é válido
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_usuario = $_GET['id'];

    // Preparar a query para excluir o usuário
    $sql = "DELETE FROM usuario WHERE id_usuario = :id_usuario";
    $stmt = $pdo->prepare($sql);

    // Associar o parâmetro :id_usuario com o valor de $id_usuario
    $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);

    // Executar a query
    try {
        $stmt->execute();

        // Verificar se alguma linha foi afetada (usuário foi excluído)
        if ($stmt->rowCount() > 0) {
            $_SESSION['mensagem'] = "Usuário excluído com sucesso!";
        } else {
            $_SESSION['mensagem'] = "Nenhum usuário encontrado com o ID fornecido.";
        }
    } catch (PDOException $e) {
        $_SESSION['mensagem'] = "Erro ao excluir usuário: " . $e->getMessage();
    }

    // Redirecionar para a listagem de usuários
    header('Location: listar_usuario.php');
    exit;
} else {
    // Se o ID não for válido, redirecionar com uma mensagem de erro
    $_SESSION['mensagem'] = "ID de usuário inválido.";
    header('Location: listar_usuario.php');
    exit;
}
?>