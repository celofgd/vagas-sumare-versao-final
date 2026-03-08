<?php
/**
 * Página de login. O usuário informa e-mail e senha; se estiver correto, é redirecionado
 * para a listagem de vagas (candidato) ou para gerenciar vagas (recrutador).
 */
require_once 'autenticacao.php';

$erros = [];

// --- Se já estiver logado, redireciona conforme o tipo de conta ---
if (esta_logado()) {
    $usuario = usuario_atual();
    if ($usuario['role'] === 'recruiter') {
        header('Location: gerenciar_vagas.php');
    } else {
        header('Location: inicio.php');
    }
    exit;
}

$papelAlvo = $_GET['role'] ?? null;
$urlRedirecionamento = $_GET['redirect'] ?? '';

// --- Processa o formulário quando o usuário clica em "Entrar" ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['password'] ?? '';
    $urlRedirecionamento = $_POST['redirect'] ?? '';

    // Validação dos campos
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erros[] = 'Informe um e-mail válido.';
    }
    if ($senha === '') {
        $erros[] = 'Informe a senha.';
    }

    if (empty($erros)) {
        // Busca o usuário no banco pelo e-mail
        $consulta = $pdo->prepare('SELECT * FROM usuarios WHERE email = ?');
        $consulta->execute([$email]);
        $usuario = $consulta->fetch(PDO::FETCH_ASSOC);

        // Verifica se encontrou o usuário e se a senha confere
        if (!$usuario || !password_verify($senha, $usuario['senha_hash'])) {
            $erros[] = 'E-mail ou senha inválidos.';
        } else {
            // Grava os dados do usuário na sessão
            $_SESSION['usuario'] = [
                'id' => $usuario['id'],
                'name' => $usuario['nome'],
                'email' => $usuario['email'],
                'role' => $usuario['papel'],
            ];

            // Redireciona para onde o usuário queria ir ou para a página padrão do tipo de conta
            if ($urlRedirecionamento) {
                header('Location: ' . $urlRedirecionamento);
            } elseif ($usuario['papel'] === 'recruiter') {
                header('Location: gerenciar_vagas.php');
            } else {
                header('Location: inicio.php');
            }
            exit;
        }
    }
}

// --- Preparar dados para o template e exibir a página ---
$titulo_pagina = 'Entrar';
$header_titulo = 'Vagas em Sumaré';
$header_sem_brasao = true;
if (!empty($_GET['msg'])) {
    $flash_msg = $_GET['msg'];
    $flash_redirect = 'entrar.php';
}
require_once 'includes/header.php';
require_once 'templates/view_entrar.php';
require_once 'includes/footer.php';
