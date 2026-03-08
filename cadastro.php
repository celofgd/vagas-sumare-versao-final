<?php
/**
 * Página de cadastro de novo usuário. O usuário escolhe ser Candidato ou Recrutador
 * e informa nome, e-mail e senha. Após o cadastro, é redirecionado para a página de login.
 */
require_once 'autenticacao.php';

$erros = [];

// Processa o formulário quando o usuário clica em "Registrar"
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['password'] ?? '';
    $senhaConfirmar = $_POST['password_confirm'] ?? '';
    $papel = $_POST['role'] ?? '';

    if ($nome === '') $erros[] = 'Informe seu nome.';
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erros[] = 'Informe um e-mail válido.';
    }
    if ($senha === '' || strlen($senha) < 6) {
        $erros[] = 'A senha deve ter pelo menos 6 caracteres.';
    }
    if ($senha !== $senhaConfirmar) {
        $erros[] = 'A confirmação de senha não confere.';
    }
    if (!in_array($papel, ['recruiter', 'candidate'], true)) {
        $erros[] = 'Selecione um tipo de conta válido.';
    }

    if (empty($erros)) {
        // Verifica se o e-mail já está cadastrado
        $consulta = $pdo->prepare('SELECT id FROM usuarios WHERE email = ?');
        $consulta->execute([$email]);
        if ($consulta->fetch()) {
            $erros[] = 'Já existe um usuário cadastrado com este e-mail.';
        } else {
            // Criptografa a senha antes de salvar
            $hashSenha = password_hash($senha, PASSWORD_DEFAULT);
            $consulta = $pdo->prepare('INSERT INTO usuarios (nome, email, senha_hash, papel) VALUES (?, ?, ?, ?)');
            $consulta->execute([$nome, $email, $hashSenha, $papel]);

            header('Location: entrar.php?msg=' . urlencode('Cadastro realizado com sucesso! Agora faça login.'));
            exit;
        }
    }
}

$titulo_pagina = 'Criar conta';
require_once 'includes/header.php';
require_once 'templates/view_cadastro.php';
require_once 'includes/footer.php';
