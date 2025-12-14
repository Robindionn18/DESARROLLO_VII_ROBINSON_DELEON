<?php
require_once 'Database.php';
require_once 'ProjectManager.php';

$pm = new ProjectManager();

$mensaje = "";
$color = "red";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $first_name = $_POST['first_name'];
    $last_name  = $_POST['last_name'];
    $email     = $_POST['email'];
    $password  = $_POST['password'];
    $password2 = $_POST['password2'];

    // Validar contraseñas iguales
    if ($password !== $password2) {
        $mensaje = "Las contraseñas no coinciden.";
    } else {

        // Nombre de usuario: puedes usar email o nombre/apellido
        $username = $email;

        // Intentar crear el usuario
        if ($pm->createUser($first_name, $last_name, $email, $password)) {
            $mensaje = "Usuario registrado con éxito.";
            $color = "green";
        } else {
            $mensaje = "Error al registrar el usuario.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Registro</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="assets/css/login/style.css" />
    </head>
    <body>
        <div class="container clearfix">
            <div class="form registration">
                <a class="logo" href="">
                    <img src="img/logo.png" alt="Logo" />
                </a>

                <form action="registro.php" method="POST">

                    <p>
                        <label>Nombre<span>*</span></label>
                        <input type="text" name="first_name" required>
                    </p>

                    <p>
                        <label>Apellido<span>*</span></label>
                        <input type="text" name="last_name" required>
                    </p>

                    <p>
                        <label>Correo<span>*</span></label>
                        <input type="email" name="email" required>
                    </p>

                    <p>
                        <label>Contraseña<span>*</span></label>
                        <input type="password" name="password" required>
                    </p>

                    <p>
                        <label>Repetir Contraseña<span>*</span></label>
                        <input type="password" name="password2" required>
                    </p>

                    <p>
                        <label>
                            <a href="login.php">Tengo una Cuenta</a>
                        </label>
                        <input type="submit" value="Registrate" />
                    </p>

                    <?php if ($mensaje): ?>
                        <p style="color: <?= $color ?>; text-align:center;"><?= $mensaje ?></p>
                    <?php endif; ?>

                </form>
            </div>
        </div>
    </body>
</html>
