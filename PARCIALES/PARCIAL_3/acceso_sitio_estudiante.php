<?php 
session_start();

if (($_SESSION['rol'])!="estudiante") {
    header("Location: acceso_sitio.php");
    exit();
}

echo "Sesión iniciada para " . $_SESSION['usuario'] . " para el rol de " . $_SESSION['rol'];

?>

<html>

<p><a href="Inicio_estudiante.php">Pagina de Inicio(Estudiante)</a></p>

<a href="cerrar_sesion.php">Cerrar Sesión</a>

</html>