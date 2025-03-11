<?php
// Conectar ao banco de dados
require_once '../connect.php';

// Verificar se o ID da conta foi passado
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('ID da conta inválido.');
}

$id_conta = $_GET['id'];

// Deletar a conta
$sql = "DELETE FROM contas WHERE id_conta = :id_conta";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id_conta', $id_conta, PDO::PARAM_INT);

try {
    $stmt->execute();
    echo "Conta deletada com sucesso!";
    header('Location: listar_contas.php'); // Redirecionar para a listagem
    exit;
} catch (PDOException $e) {
    echo "Erro ao deletar conta: " . $e->getMessage();
}
?>