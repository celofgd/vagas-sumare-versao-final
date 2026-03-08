<?php
// Opções para os campos de escala e horário no cadastro de vaga

$DIAS_SEMANA = [
    'Segunda' => 'Segunda-feira',
    'Terça' => 'Terça-feira',
    'Quarta' => 'Quarta-feira',
    'Quinta' => 'Quinta-feira',
    'Sexta' => 'Sexta-feira',
    'Sábado' => 'Sábado',
    'Domingo' => 'Domingo',
];

$HORARIOS = [];
for ($h = 6; $h <= 23; $h++) {
    $HORARIOS[] = sprintf('%02d:00', $h);
    $HORARIOS[] = sprintf('%02d:30', $h);
}
$HORARIOS[] = '00:00';

/**
 * Monta o texto de escala e horário para exibição (ex.: "Segunda a Sexta, 08:00 às 17:00").
 */
function texto_escala_horario($diaInicio, $diaFim, $horarioInicio, $horarioFim)
{
    $partes = [];
    if (!empty($diaInicio) && !empty($diaFim)) {
        $partes[] = $diaInicio . ' a ' . $diaFim;
    } elseif (!empty($diaInicio)) {
        $partes[] = $diaInicio;
    }
    if (!empty($horarioInicio) && !empty($horarioFim)) {
        $partes[] = $horarioInicio . ' às ' . $horarioFim;
    } elseif (!empty($horarioInicio)) {
        $partes[] = $horarioInicio;
    }
    return implode(', ', $partes);
}

/**
 * Monta o texto de endereço para exibição na ordem: Rua, Bairro, Número - Cidade, CEP.
 */
function texto_endereco($rua, $bairro, $cidade, $cep, $numero = '')
{
    $rua = trim($rua ?? '');
    $bairro = trim($bairro ?? '');
    $numero = trim($numero ?? '');
    $cidade = trim($cidade ?? '');
    $cep = trim($cep ?? '');
    if ($rua === '' && $cidade === '') return '';
    $logradouro = array_filter([$rua, $bairro, $numero]);
    $local = array_filter([$cidade, $cep]);
    $s1 = implode(', ', $logradouro);
    $s2 = implode(', ', $local);
    if ($s1 !== '' && $s2 !== '') return $s1 . ' - ' . $s2;
    return $s1 !== '' ? $s1 : $s2;
}
