<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Integración de PHP con HTML</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; padding: 20px; }
        .destacado { color: blue; font-weight: bold; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Gestion de membresias</h1>
    
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

    //

    <h2>Información Personal</h2>
    <p>Nombre: <span class="destacado"><?php echo $nombre; ?></span></p>
    <p>Edad: <?= $edad ?> años</p>

    <h2>Habilidades</h2>
    <ul>
        <?php foreach ($habilidades as $habilidad): ?>
            <li><?= $habilidad ?></li>
        <?php endforeach; ?>
    </ul>

</body>
</html>
    




<?php

?>