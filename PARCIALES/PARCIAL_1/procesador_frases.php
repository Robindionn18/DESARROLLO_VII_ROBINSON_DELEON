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
    <h1>Procesador de Frases</h1>
    
    <?php
    include 'operaciones_cadenas.php';
    $frases = ["Hola a todos", "El pajaro pajaro esta en la casa", "seis de sies objetos recuperados", "La lechuga morada y lechuga verde son vegetales"];
    
    ?>

    <h2>Frases</h2>
    <table>
        <tr>
            <th>Frase</th>
                <th>Frases repetidas</th>
                <th>Palabras Capitalizadas</th>
        </tr>
            <tr>
                <th></th>
                    <td></td>
                </tr>
    </table>
</body>
</html>
    