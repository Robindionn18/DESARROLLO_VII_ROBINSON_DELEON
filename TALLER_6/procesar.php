<?php
require_once 'validaciones.php';
require_once 'sanitizacion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errores = [];
    $datos = [];

    // === Campos del formulario ===
    $campos = ['nombre', 'email', 'sitio_web', 'genero', 'intereses', 'comentarios', 'fecha_nacimiento'];

    foreach ($campos as $campo) {
        if (isset($_POST[$campo])) {
            $valor = $_POST[$campo];

            // Llamar a la función de sanitización correspondiente
            $nombreFuncionSanitizar = "sanitizar" . str_replace('_', '', ucfirst($campo));
            if (function_exists($nombreFuncionSanitizar)) {
                $valorSanitizado = call_user_func($nombreFuncionSanitizar, $valor);
            } else {
                $valorSanitizado = $valor;
            }

            $datos[$campo] = $valorSanitizado;

            // Validar según el campo
            $nombreFuncionValidar = "validar" . str_replace('_', '', ucfirst($campo));
            if (function_exists($nombreFuncionValidar) && !call_user_func($nombreFuncionValidar, $valorSanitizado)) {
                $errores[] = "El campo $campo no es válido.";
            }
        }
    }

    // === Calcular edad automáticamente ===
    if (!empty($datos['fecha_nacimiento']) && validarFechaNacimiento($datos['fecha_nacimiento'])) {
        $fechaNacimientoObj = new DateTime($datos['fecha_nacimiento']);
        $hoy = new DateTime();
        $edad = $hoy->diff($fechaNacimientoObj)->y;
        $datos['edad'] = $edad;
    } else {
        $errores[] = "La fecha de nacimiento no es válida o no cumple con el rango de edad permitido.";
    }

    // === Procesar la foto de perfil ===
    if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] !== UPLOAD_ERR_NO_FILE) {
        if (!validarFotoPerfil($_FILES['foto_perfil'])) {
            $errores[] = "La foto de perfil no es válida.";
        } else {
            $directorio = 'uploads/';
            if (!file_exists($directorio)) {
                mkdir($directorio, 0777, true);
            }

            $nombreOriginal = basename($_FILES['foto_perfil']['name']);
            $extension = pathinfo($nombreOriginal, PATHINFO_EXTENSION);
            $nombreBase = pathinfo($nombreOriginal, PATHINFO_FILENAME);
            $rutaDestino = $directorio . $nombreOriginal;

            // Generar nombre único si ya existe
            $contador = 1;
            while (file_exists($rutaDestino)) {
                $rutaDestino = $directorio . $nombreBase . "_" . $contador . "." . $extension;
                $contador++;
            }

            if (move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $rutaDestino)) {
                $datos['foto_perfil'] = $rutaDestino;
            } else {
                $errores[] = "Error al subir la foto de perfil.";
            }
        }
    } else {
        $errores[] = "Debe subir una foto de perfil.";
    }

    // === Mostrar resultados o errores ===
    if (empty($errores)) {
        echo "<h2>Datos Recibidos:</h2>";
        echo "<table border='1'>";
        foreach ($datos as $campo => $valor) {
            echo "<tr><th>" . ucfirst(str_replace('_', ' ', $campo)) . "</th>";
            if ($campo === 'intereses' && is_array($valor)) {
                echo "<td>" . implode(", ", $valor) . "</td>";
            } elseif ($campo === 'foto_perfil') {
                echo "<td><img src='$valor' width='100'></td>";
            } else {
                echo "<td>$valor</td>";
            }
            echo "</tr>";
        }
        echo "</table>";

        // === Guardar datos en JSON ===
        $archivo = 'registros.json';
        $registros = [];

        if (file_exists($archivo)) {
            $contenido = file_get_contents($archivo);
            $registros = json_decode($contenido, true) ?: [];
        }

        $registros[] = $datos;
        file_put_contents($archivo, json_encode($registros, JSON_PRETTY_PRINT));

        echo "<br><a href='formulario.html'>Volver al formulario</a>";
        echo "<br><a href='resumen.php'>Ver resumen de registros</a>";

    } else {
        // === Mostrar errores y persistencia de datos ===
        echo "<h2>Errores encontrados:</h2><ul>";
        foreach ($errores as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";

        // Guardar los datos en sesión para repoblar el formulario
        session_start();
        $_SESSION['datos_previos'] = $datos;

        echo "<br><a href='formulario.php'>Volver al formulario</a>";
    }
} else {
    echo "Acceso no permitido.";
}
?>