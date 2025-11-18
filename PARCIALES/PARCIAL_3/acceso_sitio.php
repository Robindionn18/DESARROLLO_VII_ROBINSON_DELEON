<?php 
session_start();

if (($_SESSION['rol'])!="profesor") {
    header("Location: acceso_sitio_estudiante.php");
    exit();
}

echo "Sesión iniciada para " . $_SESSION['usuario'] . " para el rol de " . $_SESSION['rol'];

?>

<html>
        <p><a href="inicio_profesor.php">Pagina de Inicio(Profesor)</a></p>

<a href="cerrar_sesion.php">Cerrar Sesión</a>

</html>