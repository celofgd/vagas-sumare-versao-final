<?php
/**
 * Configuração da conexão com o banco de dados MySQL.
 */

$host_banco = '';
$nome_banco = '';
$usuario_banco = '';
$senha_banco = '';

try {
    // Cria a conexão com o MySQL
    $pdo = new PDO(
        "mysql:host=$host_banco;dbname=$nome_banco;charset=utf8mb4",
        $usuario_banco,
        $senha_banco
    );
    // Lançar exceções em caso de erro
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erro ao conectar ao banco de dados: ' . $e->getMessage());
}
