<?php
// Configurar opciones de sesión antes de iniciar la sesión
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 1);

session_start();

// Regenerar el ID de sesión periódicamente
if (!isset($_SESSION['ultima_actividad']) || (time() - $_SESSION['ultima_actividad'] > 300)) {
    session_regenerate_id(true);
    $_SESSION['ultima_actividad'] = time();
}

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = array();
}

$productos = [
    1 => ['nombre' => 'Ketchup Marge', 'precio' => 1.75],
    2 => ['nombre' => 'Donas Delicias', 'precio' => 2.75],
    3 => ['nombre' => 'Pollo Asado Gallina Feliz', 'precio' => 3.25],
    4 => ['nombre' => 'Cereal Rusty', 'precio' => 2.25],
    5 => ['nombre' => 'Galletas Cordera', 'precio' => 1.50]
];

?>
        