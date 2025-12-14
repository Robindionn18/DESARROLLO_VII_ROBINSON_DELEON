<?php
session_start();
require_once 'Database.php';
require_once 'ProjectManager.php';

$pm = new ProjectManager();
$error = "";

// Si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Intentar iniciar sesión con ProjectManager
    $user = $pm->loginUser($email, $password);
if ($user) {

    // VARIABLES DE SESIÓN CLARAS
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['role'] = $user['role'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['name'] = $user['first_name'];

    // (Opcional) Guardar todo el usuario
    $_SESSION['user'] = $user;

    if ($user['role'] == 1) {
        header("Location: catalog/lista_libro.php");
    } elseif ($user['role'] == 2) {
        header("Location: admin/addBook.php");
    }
    exit();
}

}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Login</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="assets/css/login/style.css" />
    </head>
    <body>
        <div class="container clearfix">
            <div class="form login">
                <a class="logo" href="">
                    <img src="img/logo.png" alt="Logo" />
                </a>

                <!-- Formulario con action y method -->
                <form method="POST">

                    <p>
                        <label>Correo<span>*</span></label>
                        <input type="email" name="email" required>
                    </p>

                    <p>
                        <label>Contraseña<span>*</span></label>
                        <input type="password" name="password" required>
                    </p>

                    <p>
                        <label>
                            <a href="registro.php">Registrate</a>
                        </label>
                        <input type="submit" value="Login" />
                    </p>

                    <!-- Mensaje de error -->
                    <?php if ($error): ?>
                        <p style="color: red; text-align:center;"><?= $error ?></p>
                    <?php endif; ?>

                </form>
            </div>
        </div>
    </body>
</html>
