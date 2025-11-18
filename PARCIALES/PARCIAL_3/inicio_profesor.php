
<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if(!isset($_SESSION['usuario'])) {
    header("Location: acceso_sitio.php");
    exit();
}

$id = ["1", "2", "3", "4", "5"];
$nombres = ["Juan", "Florencia", "Katy", "Desmond", "Bort"];
$notas = ["75", "82", "67", "95", "85"];


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Profesores</title>
</head>
<body>
    <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?>!</h2>
    <p>Esta es la lista de tus estudiantes.</p>
    <table border="1">
            <thead>
                <tr>
                    <th>Num. Estudiante</th>
                    <th>Nombre</th>
                    <th>Nota</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 0;
                while($i<5):?>
                <tr>
                    <td><?php echo $id[$i]; ?></td>
                    <td><?php echo $nombres[$i]; ?></td>
                    <td><?php echo $notas[$i]; ?></td>
                </tr>
                <?php $i++; endwhile; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td></td>
                        <td></td>
                        <td></td>
                </tr>
            </tfoot>
        </table>
    <a href="cerrar_sesion.php">Cerrar Sesión</a>
</body>
</html>