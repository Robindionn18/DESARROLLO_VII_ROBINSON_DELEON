<?php
session_start();

// Si ya hay una sesión activa, redirigir al panel
if(isset($_SESSION['usuario'])) {
    header("Location: acceso_sitio.php");
    exit();
}

// Procesar el formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];
    
    if(($_POST['rol'] % 2) === 0)
    {
        $rol = "estudiante";
        $nota = "81";
        $_SESSION['nota'] = $nota;
        $_SESSION['rol'] = $rol;

    }elseif($_POST['rol'] % 2 !== 0){
        $rol = "profesor";
        $_SESSION['rol'] = $rol;
    }
    

    // En un caso real, verificaríamos contra una base de datos
    if($usuario === $usuario && $contrasena === $contrasena) {
        $_SESSION['usuario'] = $usuario;
        header("Location: acceso_sitio_estudiante.php");
        exit();
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Seccion</title>
</head>
<body>
    <h2>Login</h2>
    <?php
    if (isset($error)) {
        echo "<p style='color: red;'>$error</p>";
    }
    ?>
    <form method="post" action="">
        <label for="usuario">Usuario:</label><br>
        <input type="text" id="usuario" name="usuario" required><br><br>
        <label for="contrasena">Contraseña:</label><br>
        <input type="password" id="contrasena" name="contrasena" required><br><br>
        <label for="rol">Elige el Rol: Par-Estudiante, Impar-Profesor</label><br>
        <input type="number" id="rol" name="rol" required>
        <input type="submit" value="Crear Sesión">
    </form>
</body>
</html>