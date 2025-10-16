<?php
include 'config_sesion.php';

// Redireccionar si no es una petición POST (medida de seguridad básica)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: productos.php');
    exit;
}

// 1. Validación y Sanitización de datos
$id_producto = filter_input(INPUT_POST, 'id_producto', FILTER_VALIDATE_INT);
$cantidad = filter_input(INPUT_POST, 'cantidad', FILTER_VALIDATE_INT);

// Verificar si el ID existe y la cantidad es válida
if ($id_producto !== false && $id_producto > 0 && isset($productos[$id_producto]) && $cantidad !== false && $cantidad > 0) {

    // 2. Lógica del Carrito
    if (isset($_SESSION['carrito'][$id_producto])) {
        // El producto ya está, solo aumentar la cantidad
        $_SESSION['carrito'][$id_producto] += $cantidad;
    } else {
        // El producto no está, añadirlo
        $_SESSION['carrito'][$id_producto] = $cantidad;
    }

    // Opcional: Establecer un mensaje de éxito en sesión (flash message)
    $_SESSION['mensaje'] = "Producto '" . $productos[$id_producto]['nombre'] . "' añadido al carrito.";

} else {
    $_SESSION['mensaje'] = "Error: Datos de producto inválidos.";
}

// Redireccionar de vuelta a la lista de productos
header('Location: productos.php');
exit;
?>