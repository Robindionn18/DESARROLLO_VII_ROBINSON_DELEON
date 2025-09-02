<?php

//variable

$calificacion = 59;

//calificacion

if ($calificacion >= 90) {
    $letra = "A";
} elseif ($calificacion >= 80) {
    $letra = "B";
} elseif ($calificacion >= 70) {
    $letra = "C";
} elseif ($calificacion >= 60) {
    $letra = "D";
} else {
    $letra = "F";
}
echo "<br>";

//Mensaje de resultado

echo "Tu calificación: $letra";
echo "<br>";

//Operador Ternario

$estatuternario = ($calificacion >= 60) ? "Aprobado" : "Reprobado";
echo "Estado: $estatuternario<br><br>";

//Uso switch

switch (true) {
    case ($letra == "A"):
        echo "Excelente trabajo.<br>";
        break;
    case ($letra == "B"):
        echo "Buen trabajo.<br>";
        break;
    case ($letra == "C"):
        echo "Trabajo aceptable.<br>";
        break;
    case ($letra == "D"):
        echo "Necesita mejorar.<br>";
        break;
    case ($letra == "F"):
        echo "Debes esforzarte más.<br>";
        break;
    default:
        echo "Desempeño insuficiente.<br>";
}
echo "<br>";

?>