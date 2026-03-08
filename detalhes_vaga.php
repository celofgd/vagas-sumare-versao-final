<?php
/**
 * Página de detalhes de uma vaga.
 */
require_once 'autenticacao.php';
exigir_papel('candidate');
require_once 'beneficios_opcoes.php';
require_once 'formatar_salario.php';
require_once 'opcoes_escala.php';

$idVaga = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$consulta = $pdo->prepare('SELECT * FROM vagas WHERE id = ?');
$consulta->execute([$idVaga]);
$vaga = $consulta->fetch(PDO::FETCH_ASSOC);

if (!$vaga) {
    http_response_code(404);
    echo 'Vaga não encontrada.';
    exit;
}

$titulo_pagina = htmlspecialchars($vaga['titulo']) . ' - Detalhes da vaga';
$header_titulo = 'Detalhes da vaga';
$header_extra_html = '<div><a href="inicio.php" class="btn btn-secondary">Voltar para vagas</a></div>';
require_once 'includes/header.php';
require_once 'templates/view_detalhes_vaga.php';
require_once 'includes/footer.php';
