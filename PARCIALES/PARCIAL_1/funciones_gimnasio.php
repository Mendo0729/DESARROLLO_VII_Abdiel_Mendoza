<?php

function calcular_descuento($antiguada_meses) {
    $descuentoPorcentaje = 0;

    if ($antiguada_meses >= 3 && $antiguada_meses <= 12) {
        $descuentoPorcentaje = 8;
    } elseif ($antiguada_meses >= 13 && $antiguada_meses <= 24) {
        $descuentoPorcentaje = 12;
    } elseif ($antiguada_meses > 24) {
        $descuentoPorcentaje = 20;
    }

    return $descuentoPorcentaje;
}

function calcular_seguro_medico($cuotaBase) {
    $seguroMedico = $cuotaBase * 0.05;
    return $seguroMedico;
}

function calcular_total($cuotaBase, $descuentoPorcentaje, $seguroMedico) {

    $descuento = $cuotaBase * ($descuentoPorcentaje/100);
    
    $total = $cuotaBase - $descuento + $seguroMedico;
    return $total;
}


?>