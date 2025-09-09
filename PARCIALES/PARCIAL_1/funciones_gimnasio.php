<?php


// Calcular promocion

function calcular_promocion($antiguedad_meses) {
    $descuento = 0;
    if ($antiguedad_meses > 24) {
        $descuento = 0.20;
    echo "Tu decuento es del 20%.<br>";
} elseif ($antiguedad_meses >= 13 && $antiguedad_meses <= 24) {
    $descuento = 0.12;
    echo "Tu decuento es del 12%.<br>";
} elseif ($antiguedad_meses >= 3 && $antiguedad_meses <= 12) {
    $descuento = 0.08;
    echo "Tu decuento es del 8%.<br>";
} elseif ($antiguedad_meses < 3) {
    echo "No aplica para descuento.<br>";
} else {
    echo "No aplica para descuento<br>";
}
return $descuento;
}


// calcular seguro medico

function calcular_seguro_medico($cuota_base) {

    $seguro_medico_por = $cuota_base * 0.05 ;
    $seguro_medico = $cuota_base + $seguro_medico_por;
    return $seguro_medico;

}

// Calcular Cuota final 

function calcular_cuota_final($cuota_base, $descuento_porcentaje, $seguro_medico) {
    $descuento = $cuota_base * $descuento_porcentaje ;
    $cuota_final = $cuota_base - $descuento + $seguro_medico;
    return $cuota_final;

}







?>