<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$db = 'gerenciador_db'; // Nome do seu banco de dados

try {
    // Criar uma conexão PDO
    $pdo = new PDO("mysql:host=$hostname;dbname=$db;charset=utf8", $username, $password);

    // Configurar o PDO para lançar exceções em caso de erro
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // echo "Conexão bem-sucedida!"; // Isso é opcional, apenas para depuração
} catch (PDOException $e) {
    die("Erro ao conectar: " . $e->getMessage());
}
?>