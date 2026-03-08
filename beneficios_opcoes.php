<?php
// Opções de benefícios
$BENEFICIOS_OPCOES = [
    'vale_refeicao' => 'Vale refeição',
    'vale_transporte' => 'Vale transporte',
    'plano_saude' => 'Plano de saúde',
    'home_office' => 'Home office',
    'seguro_vida' => 'Seguro de vida',
    'bonus_plr' => 'Bônus / PLR',
    'horario_flexivel' => 'Horário flexível',
    'day_off' => 'Day off (aniversário)',
    'cursos_treinamentos' => 'Cursos e treinamentos',
];

function beneficios_para_rotulos($textoBeneficios)
{
    global $BENEFICIOS_OPCOES;
    if ($textoBeneficios === null || $textoBeneficios === '') return [];
    $chaves = array_map('trim', explode(',', $textoBeneficios));
    $rotulos = [];
    foreach ($chaves as $chave) {
        if (isset($BENEFICIOS_OPCOES[$chave])) $rotulos[] = $BENEFICIOS_OPCOES[$chave];
    }
    return $rotulos;
}
