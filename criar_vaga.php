<?php
/**
 * Formulário para o recrutador cadastrar uma nova vaga.
 */
require_once 'autenticacao.php';
exigir_papel('recruiter');
require_once 'beneficios_opcoes.php';
require_once 'formatar_salario.php';
require_once 'opcoes_escala.php';

$erros = [];

// Processa o envio do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo'] ?? '');
    $empresa = trim($_POST['empresa'] ?? '');
    $rua = trim($_POST['rua'] ?? '');
    $numero = trim($_POST['numero'] ?? '');
    $bairro = trim($_POST['bairro'] ?? '');
    $cidade = trim($_POST['cidade'] ?? '');
    $cep = trim($_POST['cep'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $salario = trim($_POST['salario'] ?? '');
    $regime = trim($_POST['regime'] ?? '');
    if (!in_array($regime, ['CLT', 'CNPJ', 'Freelance'], true)) $regime = null;
    $dia_inicio = trim($_POST['dia_inicio'] ?? '');
    $dia_fim = trim($_POST['dia_fim'] ?? '');
    $horario_inicio = trim($_POST['horario_inicio'] ?? '');
    $horario_fim = trim($_POST['horario_fim'] ?? '');
    $listaBeneficios = isset($_POST['beneficios']) && is_array($_POST['beneficios'])
        ? array_filter(array_map('trim', $_POST['beneficios']))
        : [];
    $beneficios = implode(',', array_intersect($listaBeneficios, array_keys($BENEFICIOS_OPCOES)));
    $meio_contato = trim($_POST['meio_contato'] ?? '');
    $naoPossuiEndereco = !empty($_POST['nao_possui_endereco']);
    if ($naoPossuiEndereco) {
        $rua = $numero = $bairro = $cidade = $cep = '';
    }

    if ($titulo === '') $erros[] = 'Informe o título da vaga.';
    if ($empresa === '') $erros[] = 'Informe a empresa.';
    if (!$naoPossuiEndereco) {
        if ($rua === '') $erros[] = 'Informe a rua.';
        if ($bairro === '') $erros[] = 'Informe o bairro.';
        if ($cidade === '') $erros[] = 'Informe a cidade.';
        if ($cep === '') $erros[] = 'Informe o CEP.';
        if ($cep !== '') $erros = array_merge($erros, validar_cep($cep));
    }
    if ($descricao === '') $erros[] = 'Informe a descrição.';
    $erros = array_merge($erros, validar_salario($salario));
    if ($meio_contato === '') $erros[] = 'Informe o meio de contato da empresa.';
    if ($dia_inicio === '') $erros[] = 'Selecione o dia de início da escala.';
    if ($dia_fim === '') $erros[] = 'Selecione o dia de fim da escala.';
    if ($horario_inicio === '') $erros[] = 'Selecione o horário de início.';
    if ($horario_fim === '') $erros[] = 'Selecione o horário de fim.';
    if ($titulo !== '' && mb_strlen($titulo) > VAGA_MAX_TITLE) $erros[] = 'O título deve ter no máximo ' . VAGA_MAX_TITLE . ' caracteres.';
    if ($empresa !== '' && mb_strlen($empresa) > VAGA_MAX_COMPANY) $erros[] = 'A empresa deve ter no máximo ' . VAGA_MAX_COMPANY . ' caracteres.';
    if ($rua !== '' && mb_strlen($rua) > VAGA_MAX_RUA) $erros[] = 'A rua deve ter no máximo ' . VAGA_MAX_RUA . ' caracteres.';
    if ($numero !== '' && mb_strlen($numero) > VAGA_MAX_NUMERO) $erros[] = 'O número deve ter no máximo ' . VAGA_MAX_NUMERO . ' caracteres.';
    if ($bairro !== '' && mb_strlen($bairro) > VAGA_MAX_BAIRRO) $erros[] = 'O bairro deve ter no máximo ' . VAGA_MAX_BAIRRO . ' caracteres.';
    if ($cidade !== '' && mb_strlen($cidade) > VAGA_MAX_CIDADE) $erros[] = 'A cidade deve ter no máximo ' . VAGA_MAX_CIDADE . ' caracteres.';
    if ($salario !== '' && mb_strlen($salario) > VAGA_MAX_SALARY) $erros[] = 'O salário deve ter no máximo ' . VAGA_MAX_SALARY . ' caracteres.';
    if ($meio_contato !== '' && mb_strlen($meio_contato) > VAGA_MAX_MEIO_CONTATO) $erros[] = 'O meio de contato deve ter no máximo ' . VAGA_MAX_MEIO_CONTATO . ' caracteres.';
    if ($descricao !== '' && mb_strlen($descricao) > VAGA_MAX_DESCRIPTION) $erros[] = 'A descrição deve ter no máximo ' . VAGA_MAX_DESCRIPTION . ' caracteres.';

    if (empty($erros)) {
        $usuario = usuario_atual();
        $localizacaoMontada = $naoPossuiEndereco ? null : ($rua . ($numero !== '' ? ', ' . $numero : '') . ', ' . $bairro . ' - ' . $cidade . ', ' . $cep);
        $consulta = $pdo->prepare('INSERT INTO vagas (titulo, empresa, localizacao, rua, numero, bairro, cidade, cep, descricao, salario, regime, dia_inicio, dia_fim, horario_inicio, horario_fim, beneficios, meio_contato, criado_por) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $consulta->execute([
            $titulo, $empresa, $localizacaoMontada, $rua ?: null, $numero ?: null, $bairro ?: null, $cidade ?: null, $cep ?: null, $descricao,
            $salario ?: null, $regime, $dia_inicio ?: null, $dia_fim ?: null, $horario_inicio ?: null, $horario_fim ?: null,
            $beneficios ?: null, $meio_contato, $usuario['id']
        ]);
        header('Location: gerenciar_vagas.php?msg=Vaga+criada+com+sucesso');
        exit;
    }
    $dadosFormulario = [
        'titulo' => $titulo,
        'empresa' => $empresa,
        'rua' => $rua,
        'numero' => $numero,
        'bairro' => $bairro,
        'cidade' => $cidade,
        'cep' => $cep,
        'nao_possui_endereco' => $naoPossuiEndereco,
        'descricao' => $descricao,
        'salario' => $salario,
        'regime' => $regime,
        'dia_inicio' => $dia_inicio,
        'dia_fim' => $dia_fim,
        'horario_inicio' => $horario_inicio,
        'horario_fim' => $horario_fim,
        'beneficios' => $beneficios ?? '',
        'meio_contato' => $meio_contato,
    ];
} else {
    $dadosFormulario = ['nao_possui_endereco' => false];
}

$titulo_pagina = 'Cadastrar vaga';
$usuario = usuario_atual();
require_once 'includes/header.php';
require_once 'templates/view_criar_vaga.php';
require_once 'includes/footer.php';
