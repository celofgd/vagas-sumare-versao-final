<?php
/**
 * Inicia a sessão PHP e oferece funções para verificar se o usuário está logado.
 */

require_once __DIR__ . '/config_banco.php';

// Inicia a sessão apenas se ainda não foi iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Retorna os dados do usuário logado (id, name, email, role) ou null se não estiver logado.
 */
function usuario_atual()
{
    return $_SESSION['usuario'] ?? null;
}

/**
 * Retorna true se existe um usuário logado, false caso contrário.
 */
function esta_logado()
{
    return usuario_atual() !== null;
}

/**
 * Exige que o usuário esteja logado com um determinado papel (recruiter ou candidate).
 * Se não estiver, redireciona para a página de login.
 */
function exigir_papel($papel)
{
    $usuario = usuario_atual();
    if (!$usuario || $usuario['role'] !== $papel) {
        $redirecionar = isset($_SERVER['REQUEST_URI']) ? urlencode($_SERVER['REQUEST_URI']) : '';
        header('Location: entrar.php?role=' . urlencode($papel) . '&redirect=' . $redirecionar);
        exit;
    }
}
