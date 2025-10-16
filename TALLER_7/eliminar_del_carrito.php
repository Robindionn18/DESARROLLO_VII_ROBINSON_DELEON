<?php
include 'config_sesion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ver_carrito.php');
    exit;
}

$id_producto = filter_input(INPUT_POST, 'id_producto', FILTER_VALIDATE_INT);

if ($id_producto !== false && $id_producto > 0 && isset($_SESSION['carrito'][$id_producto])) {
    // Eliminar el producto del array del carrito
    unset($_SESSION['carrito'][$id_producto]);

    $_SESSION['mensaje'] = "Producto eliminado del carrito.";
} else {
    $_SESSION['mensaje'] = "Error: Producto no encontrado en el carrito.";
}

header('Location: ver_carrito.php');
exit;
?>