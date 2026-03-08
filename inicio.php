<?php
/**
 * Página principal para o candidato: lista todas as vagas cadastradas.
 * Só pode ser acessada por quem está logado como candidato.
 */
require_once 'autenticacao.php';
exigir_papel('candidate');

require_once 'beneficios_opcoes.php';
require_once 'formatar_salario.php';
require_once 'opcoes_escala.php';

// Busca todas as vagas no banco, da mais recente para a mais antiga
$consulta = $pdo->query('SELECT * FROM vagas ORDER BY criado_em DESC');
$vagas = $consulta->fetchAll(PDO::FETCH_ASSOC);

$titulo_pagina = 'Vagas em Sumaré';
$usuario = usuario_atual();
if (!empty($_GET['msg'])) {
    $flash_msg = $_GET['msg'];
    $flash_redirect = 'inicio.php';
}
require_once 'includes/header.php';
require_once 'templates/view_inicio.php';
require_once 'includes/footer.php';
