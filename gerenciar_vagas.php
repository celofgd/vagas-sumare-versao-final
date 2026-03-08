<?php
/**
 * Só mostra vagas onde criado_por = id do usuário logado.
 */
require_once 'autenticacao.php';
exigir_papel('recruiter');
require_once 'opcoes_escala.php';

$usuario = usuario_atual();
$userId = (int) $usuario['id'];

// Remover a vaga.
if (isset($_GET['delete_id'])) {
    $idExcluir = (int) $_GET['delete_id'];
    $consulta = $pdo->prepare('DELETE FROM vagas WHERE id = ? AND criado_por = ?');
    $consulta->execute([$idExcluir, $userId]);
    header('Location: gerenciar_vagas.php?msg=Vaga+excluida+com+sucesso');
    exit;
}

// Lista as vagas criadas.
$consulta = $pdo->prepare('SELECT * FROM vagas WHERE criado_por = ? ORDER BY criado_em DESC');
$consulta->execute([$userId]);
$vagas = $consulta->fetchAll(PDO::FETCH_ASSOC);

$titulo_pagina = 'Gerenciar Vagas';
if (!empty($_GET['msg'])) {
    $flash_msg = $_GET['msg'];
    $flash_redirect = 'gerenciar_vagas.php';
}
require_once 'includes/header.php';
require_once 'templates/view_gerenciar_vagas.php';
require_once 'includes/footer.php';
