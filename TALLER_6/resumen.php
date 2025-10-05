<?php
$archivo = 'registros.json';
$registros = [];

if (file_exists($archivo)) {
    $registros = json_decode(file_get_contents($archivo), true) ?: [];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resumen de Registros</title>
</head>
<body>
<h2>Usuarios Registrados</h2>
<table border="1">
    <tr>
        <th>Nombre</th>
        <th>Email</th>
        <th>Edad</th>
        <th>Fecha Nacimiento</th>
        <th>Género</th>
        <th>Foto</th>
    </tr>
    <?php foreach ($registros as $r): ?>
        <tr>
            <td><?= htmlspecialchars($r['nombre']) ?></td>
            <td><?= htmlspecialchars($r['email']) ?></td>
            <td><?= htmlspecialchars($r['edad']) ?></td>
            <td><?= htmlspecialchars($r['fecha_nacimiento']) ?></td>
            <td><?= htmlspecialchars($r['genero']) ?></td>
            <td><img src="<?= htmlspecialchars($r['foto']) ?>" width="80"></td>
        </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
