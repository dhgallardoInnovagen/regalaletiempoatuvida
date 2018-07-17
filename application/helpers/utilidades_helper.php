<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('formato_fecha')) {

    function formato_fecha($fecha) {       
        if ($fecha != NULL) {                        
            $separador = '';
            $dia = '';
            $mes = '';
            $año = '';
            if (substr_count($fecha, '/') == 2) {//si el separadoe es /                
                $separador = '/';
            } else {                
                if (substr_count($fecha, '-') == 2) {  //si el separador de fecha es -                  
                    $separador = '-';
                } else {                    
                    return NULL; //La fecha no tiene un formato válido     
                }
            }
            list($dato1, $dato2, $dato3) = explode($separador, $fecha);
            if (strlen($dato1) == 4) { //si el primer elemento contiene el año formtaoto año/mes/dia                
                $año = intval($dato1);
                $mes = intval($dato2);
                $dia = intval($dato3);
            } else {
                if (strlen($dato3) == 4) {//si el ultimo elemento contiene el año, formato dia/mes/años                    
                    $dia = intval($dato1);
                    $mes = intval($dato2);
                    $año = intval($dato3);
                } else {                    
                    return NULL; // FORMATO INCORRECTO
                }
            }            
            return (date("Y-m-d", mktime(0, 0, 0, $mes, $dia, $año)));
        }        
        return NULL;
    }

}
if (!function_exists('calcular_brecha')) {

    function calcular_brecha($rowP, $valorP) {
        $resultado = '';
        if (!is_nan($valorP)) {

            // $resultadoF = $valorP * $rowP->FACTOR_DE_CALCULO;
            $resultadoF = $valorP;
            $ma = str_replace(",", ".", $rowP->META_ANUAL);
            $resultado = $resultadoF - $ma;
            $operador = $rowP->SIMBOLO_OPERADOR;

            if ($operador == '<') {
                $resultado += 1;
                if ($resultado < 0) {
                    $resultado = 0;
                }
            } else if ($operador == '<=' && $resultado <= 0) {
                $resultado = 0;
            } else if ($operador == '>') {
                $resultado -= 1;
                if ($resultado > 0) {
                    $resultado = 0;
                }
            } else if ($operador == '>=' && $resultado >= 0) {
                $resultado = 0;
            }
            $resultado = abs(round($resultado, 2));
        }
        return $resultado;
    }

}

if (!function_exists('calcularEficacia')) {

    function calcularEficacia($metaAnual, $operador, $consolidado, $brecha) {
        $numeroFormula = 0;
        $divisionPorCero = false;
        $eficacia = null;
        if (strcmp($metaAnual, "") !== 0 && strcmp($consolidado, "") !== 0) {
            if (strcmp($operador, '<') == 0 || strcmp($operador, '<=') == 0) {
                $numeroFormula = 1; //Formula1 = (meta anual / valor observado )* 100
            } else {
                if (strcmp($operador, '>') == 0 || strcmp($operador, '>=') == 0) {
                    $numeroFormula = 2; // Formula2 = (valor observado / meta anual )* 100
                }
            }
            if ($numeroFormula == 1) {//cuando operador <, <=
                $eficacia = aplicaFormula($metaAnual, $consolidado, $divisionPorCero);
            } else {
                if ($numeroFormula == 2) {// Cuando operador >, >=
                    $eficacia = aplicaFormula($consolidado, $metaAnual, $divisionPorCero);
                } else {//cuando el operador es =
                    if ($consolidado > $metaAnual) {
                        $eficacia = aplicaFormula($metaAnual, $consolidado, $divisionPorCero);
                    } else {
                        $eficacia = aplicaFormula($consolidado, $metaAnual, $divisionPorCero);
                    }
                }
            }
            if ($divisionPorCero) {
                $eficacia = 100 - abs($consolidado);
            }
        }
        if (floatval($brecha) == 0 || $eficacia > 100) {
            $eficacia = 100;
        }
        if ($eficacia < 0) {
            $eficacia = 0;
        }
        if ($consolidado < 0 && strcmp($operador, '>=') == 0) {
            $eficacia = 0;
        }
        return $eficacia;
    }

}

if (!function_exists('aplicaFormula')) {

    function aplicaFormula($numerador, $denominador, &$divisionPorCero) {
        if ($denominador != 0) {
            return round(($numerador * 100) / $denominador, 2);
        } else {
            $divisionPorCero = true;
        }
        return null;
    }

}


if (!function_exists('formato_decimal')) {

    function formato_decimal($valorP) {
        if ($valorP) {
            if (substr($valorP, 0, 1) == '.') {
                $valorP = '0' . $valorP;
            }
        }
        return $valorP;
    }

}

if (!function_exists('formato_decimal')) {

    function formatValor($val) {
        if ($val) {
            $array = explode("  =  ", $val);
            if ($array . length == 2) {
                $val = $array[0] . '  =  ' . $this->formato_decimal($array[1]);
            }
        }
        return $val;
    }

}

if (!function_exists('obtener_color_semaforo')) {

    function obtener_color_semaforo($valor, $porcentaje_menor, $porcentaje_mayor, $operador) {
        $verde = '#00a650';
        $amarillo = '#fff100';
        $rojo = '#ee1d24';
        $background = '';
        if ($operador == '<' || $operador == '<=') {
            if ($valor <= $porcentaje_menor) {
                $background = $verde;
            } else {
                if ($valor >= $porcentaje_mayor) {
                    $background = $rojo;
                } else {
                    $background = $amarillo;
                }
            }
        } else {
            if ($operador == '>' || $operador == '>=') {
                if ($valor >= $porcentaje_mayor) {
                    $background = $verde;
                } else {
                    if ($valor <= $porcentaje_menor) {
                        $background = $rojo;
                    } else {
                        $background = $amarillo;
                    }
                }
            } else {   //Simbolo igual
                if ($valor < $porcentaje_menor) {
                    $background = $amarillo;
                } else {
                    if ($valor > $porcentaje_mayor) {
                        $background = $rojo;
                    } else {
                        $background = $verde;
                    }
                }
            }
        }
        return $background;
    }

}