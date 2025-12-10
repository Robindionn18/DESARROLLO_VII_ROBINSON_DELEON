<?php
require_once 'Database.php';
require_once 'ProjectManager.php';

$pm = new ProjectManager();

$mensaje = "";
$color = "red";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $firstname = $_POST['firstname'];
    $lastname  = $_POST['lastname'];
    $email     = $_POST['email'];
    $password  = $_POST['password'];
    $password2 = $_POST['password2'];

    // Validar contraseñas iguales
    if ($password !== $password2) {
        $mensaje = "Las contraseñas no coinciden.";
    } else {

        // Nombre de usuario: puedes usar email o nombre/apellido
        $username = $email;

        // Rol por defecto
        $role = "user";

        // Intentar crear el usuario
        if ($pm->createUser($username, $password, $role)) {
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
        <link rel="stylesheet" href="css/style.css" />
    </head>
    <body>
        <div class="container clearfix">
            <div class="form registration">
                <a class="logo" href="">
                    <img src="img/logo.png" alt="Logo" />
                </a>

                <form method="POST">

                    <p>
                        <label>First name<span>*</span></label>
                        <input type="text" name="firstname" required>
                    </p>

                    <p>
                        <label>Last name<span>*</span></label>
                        <input type="text" name="lastname" required>
                    </p>

                    <p>
                        <label>Email address<span>*</span></label>
                        <input type="email" name="email" required>
                    </p>

                    <p>
                        <label>Password<span>*</span></label>
                        <input type="password" name="password" required>
                    </p>

                    <p>
                        <label>Again password<span>*</span></label>
                        <input type="password" name="password2" required>
                    </p>

                    <p>
                        <label>
                            <a href="login.php">Have an account</a>
                        </label>
                        <input type="submit" value="Signup" />
                    </p>

                    <?php if ($mensaje): ?>
                        <p style="color: <?= $color ?>; text-align:center;"><?= $mensaje ?></p>
                    <?php endif; ?>

                </form>
            </div>
        </div>
    </body>
</html>
