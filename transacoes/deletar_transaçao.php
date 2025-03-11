<?php
// Conectar ao banco de dados
require_once '../connect.php';

// Verificar se o ID da transação foi passado
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('ID da transação inválido.');
}

$id_transacao = $_GET['id'];

// Deletar a transação
$sql = "DELETE FROM transacoes WHERE id_transacao = :id_transacao";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id_transacao', $id_transacao, PDO::PARAM_INT);

try {
    $stmt->execute();
    echo "Transação deletada com sucesso!";
    header('Location: listar_transacoes.php'); // Redirecionar para a listagem
    exit;
} catch (PDOException $e) {
    echo "Erro ao deletar transação: " . $e->getMessage();
}
?>