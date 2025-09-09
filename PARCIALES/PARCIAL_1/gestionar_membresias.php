<?php

include 'funciones_gimansio.php';

$membresias = ["basica" => 80 , "premium" => 120 , "vip" => 180, "familiar" => 250 , "corporativa" => 300];

$miembros = [
    "Juan Pérez" => ["tipo" => "premium", "antiguedad" => 15],
    "Ana García" => ["tipo" => "basica", "antiguedad" => 2],
    "Carlos López" => ["tipo" => "vip", "antiguedad" => 30],
    "María Rodríguez" => ["tipo" => "familiar", "antiguedad" => 8],
    "Luis Martínez" => ["tipo" => "corporativa", "antiguedad" => 18],
];

foreach($miembros as $miembros => $valor){
    echo "$clave: $valor<br>";
}

?>