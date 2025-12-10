<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Define the base path for includes
define('BASE_PATH', __DIR__ . '/');

// Include the configuration file
require_once 'config.php';

// Include necessary files
require_once BASE_PATH . '../Database.php';
require_once 'ProjectManager.php';
require_once 'Project.php';

$projecto = new ProjectManager();
$error = "";

// Si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Intentar iniciar sesión con ProjectManager
    $user = $projecto->loginUser($username, $password);

    if ($user) {
        $_SESSION['user'] = $user;
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Login</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/style.css" />
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
                        <input type="text" name="username" required>
                    </p>

                    <p>
                        <label>Contraseña<span>*</span></label>
                        <input type="password" name="password" required>
                    </p>

                    <p>
                        <label>
                            <a href="registros.php">Registrate</a>
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
