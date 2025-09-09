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
    $frases = ["Hola a todos", "El pajaro pajaro esta en la casa", "seis de sies objetos recuperados", "La lechuga morada y lechuga verde son vegetales"];
    
    ?>

    <h2>Frases</h2>
    <table>
        <tr>
            <th>Número</th>
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <th><?= $i ?></th>
            <?php endfor; ?>
        </tr>
        <?php for ($i = 1; $i <= 10; $i++): ?>
            <tr>
                <th><?= $i ?></th>
                <?php for ($j = 1; $j <= 5; $j++): ?>
                    <td><?= $i * $j ?></td>
                <?php endfor; ?>
            </tr>
        <?php endfor; ?>
    </table>
</body>
</html>
    