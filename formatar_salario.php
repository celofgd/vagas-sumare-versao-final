<?php
if (!function_exists('mb_strlen')) {
    function mb_strlen($str, $encoding = null) {
        return strlen($str);
    }
}

/**
 * Valida o campo salário: obrigatório, não pode ser "A combinar" e não pode ser zero.
 */
function validar_salario($valor)
{
    $erros = [];
    $valor = trim($valor ?? '');
    if ($valor === '') {
        $erros[] = 'O salário é obrigatório.';
        return $erros;
    }
    if (stripos($valor, 'a combinar') !== false) {
        $erros[] = 'O salário não pode ser "A combinar".';
        return $erros;
    }
    if (preg_match_all('/\d[\d.,]*\d|\d+/', $valor, $matches)) {
        $temZero = false;
        foreach ($matches[0] as $n) {
            $num = salario_br_para_numero($n);
            if ($num === 0.0) {
                $temZero = true;
                break;
            }
        }
        if ($temZero) {
            $erros[] = 'O salário não pode ser zero.';
        }
    }
    return $erros;
}

/** Limites de caracteres dos campos da vaga. */
const VAGA_MAX_TITLE = 60;
const VAGA_MAX_COMPANY = 30;
const VAGA_MAX_RUA = 100;
const VAGA_MAX_NUMERO = 10;
const VAGA_MAX_BAIRRO = 60;
const VAGA_MAX_CIDADE = 100;
const VAGA_MAX_CEP = 9;
const VAGA_MAX_SALARY = 12;
const VAGA_MAX_MEIO_CONTATO = 500;
const VAGA_MAX_DESCRIPTION = 10000;

/**
 * Valida o CEP.
 */
function validar_cep($valor)
{
    $erros = [];
    $valor = trim($valor ?? '');
    if ($valor === '') return $erros;
    if (strlen($valor) > VAGA_MAX_CEP) {
        $erros[] = 'O CEP deve ter no máximo 9 caracteres (ex.: 00000-000).';
        return $erros;
    }
    $digitos = preg_replace('/\D/', '', $valor);
    if (strlen($digitos) !== 8) {
        $erros[] = 'O CEP deve conter exatamente 8 dígitos (ex.: 13302-093 ou 13302093).';
    }
    return $erros;
}

/**
 * Converte string em padrão brasileiro para número.
 */
function salario_br_para_numero($str)
{
    $str = trim($str);
    $str = str_replace('.', '', $str);  // remove separador de milhar
    $str = str_replace(',', '.', $str);  // vírgula vira decimal
    return $str === '' || $str === '.' ? 0.0 : (float) $str;
}

/**
 * Formata o valor de salário para exibição em padrão brasileiro.
 */
function formatar_salario($valor)
{
    $valor = trim($valor);
    if ($valor === '') return '';

    // Extrai trechos que parecem número (dígitos com , ou .)
    if (preg_match_all('/\d[\d.,]*\d|\d+/', $valor, $matches)) {
        $numeros = $matches[0];
        $formatados = [];
        foreach ($numeros as $n) {
            $num = salario_br_para_numero($n);
            if ($num > 0 || $n === '0' || preg_match('/^[\d.,]+$/', $n)) {
                $formatados[] = 'R$ ' . number_format($num, 2, ',', '.');
            }
        }
        if (count($formatados) === 1) {
            return $formatados[0];
        }
        if (count($formatados) === 2) {
            return $formatados[0] . ' - ' . $formatados[1];
        }
    }

    return $valor;
}
