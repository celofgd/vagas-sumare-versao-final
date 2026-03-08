<?php
/**
 * Encerra a sessão do usuário e redireciona para a página de login.
 */
require_once 'autenticacao.php';

$_SESSION = [];
session_destroy();

header('Location: entrar.php');
exit;
