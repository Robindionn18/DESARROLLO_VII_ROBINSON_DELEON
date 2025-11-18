
<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if(!isset($_SESSION['usuario'])) {
    header("Location: acceso_sitio.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Estudiantes</title>
</head>
<body>
    <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?>!</h2>
    <p>Esta es tu nota: <?php  echo htmlspecialchars($_SESSION['nota']);?>.</p>
    <a href="cerrar_sesion.php">Cerrar Sesión</a>
</body>
</html>