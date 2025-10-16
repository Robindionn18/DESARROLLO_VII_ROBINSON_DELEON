<?php
include 'config_sesion.php'; // Incluye la configuración y los productos ($productos)

// Redireccionar si el carrito está vacío o no es POST
if (empty($_SESSION['carrito']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ver_carrito.php');
    exit;
}

// 1. Obtener y sanitizar el nombre del usuario
$nombre_usuario = filter_input(INPUT_POST, 'nombre_usuario', FILTER_SANITIZE_STRING);

// 2. Establecer la Cookie de Usuario
if (!empty($nombre_usuario)) {
    $expiracion = time() + (86400 * 1); // 86400 segundos = 1 día (24 horas)
    $path = '/';
    $domain = '';
    $secure = isset($_SERVER['HTTPS']); // Usar 'secure' si es HTTPS
    $httponly = true;

    // Configura la cookie para recordar al usuario por 24 horas
    setcookie('nombre_usuario', $nombre_usuario, $expiracion, $path, $domain, $secure, $httponly);
}

// 3. Preparar el Resumen de la Compra
$resumen_compra = $_SESSION['carrito'];
$total_compra = 0;
foreach ($resumen_compra as $id => $cantidad) {
    if (isset($productos[$id])) {
        $total_compra += $productos[$id]['precio'] * $cantidad;
    }
}

// 4. Vaciar el Carrito (Eliminar la variable de sesión del carrito)
unset($_SESSION['carrito']);

// Opcional: Mostrar un mensaje final de éxito
$_SESSION['mensaje'] = "¡Compra finalizada con éxito! Total: $" . number_format($total_compra, 2);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Checkout Finalizado</title>
</head>
<body>
    <h1>¡Compra Finalizada!</h1>

    <p style="color: green; font-weight: bold;"><?php echo htmlspecialchars($_SESSION['mensaje']); ?></p>

    <?php if (!empty($nombre_usuario)): ?>
        <p>Gracias por tu compra, **<?php echo htmlspecialchars($nombre_usuario); ?>**. Recordaremos tu nombre para tu próxima visita (durante 24 horas).</p>
    <?php endif; ?>

    <h2>Resumen de la Orden:</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($resumen_compra as $id => $cantidad):
                $producto = $productos[$id];
                $subtotal = $producto['precio'] * $cantidad;
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($cantidad); ?></td>
                    <td>$<?php echo htmlspecialchars(number_format($subtotal, 2)); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" align="right"><strong>TOTAL PAGADO:</strong></td>
                <td><strong>$<?php echo htmlspecialchars(number_format($total_compra, 2)); ?></strong></td>
            </tr>
        </tfoot>
    </table>

    <p><a href="productos.php">Volver a la tienda</a></p>
</body>
</html>