<?php
// Cabeçalho comum: título da página, logo, nome do usuário logado e botão Sair
$header_titulo = $header_titulo ?? $titulo_pagina ?? 'Vagas em Sumaré';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($titulo_pagina ?? 'Vagas em Sumaré') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <?php if (!empty($flash_msg)): ?>
    <div id="flash-msg" data-msg="<?= htmlspecialchars($flash_msg, ENT_QUOTES) ?>" data-redirect="<?= htmlspecialchars($flash_redirect ?? '', ENT_QUOTES) ?>" style="display:none"></div>
    <?php endif; ?>
    <script src="js/common.js"></script>

    <header>
        <h1 class="<?= !empty($header_sem_brasao) ? '' : 'header-titulo-com-bandeira' ?>">
            <?php if (empty($header_sem_brasao)): ?>
            <img src="img/brasao.png" alt="Brasão de Sumaré" class="header-bandeira">
            <?php endif; ?>
            <?= htmlspecialchars($header_titulo) ?>
        </h1>
        <?php if (!empty($usuario) && isset($usuario['name']) && (string) $usuario['name'] !== ''): ?>
        <div>
            <span class="user-info">Olá, <?= htmlspecialchars((string) $usuario['name'], ENT_QUOTES, 'UTF-8') ?></span>
            <a href="sair.php" class="btn">Sair</a>
        </div>
        <?php elseif (!empty($header_extra_html)): ?>
        <?= $header_extra_html ?>
        <?php endif; ?>
    </header>
