<?php
include 'config_sesion.php'; // Incluye la configuración y los productos ($productos)

$total_compra = 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Ver Carrito</title>
</head>
<body>
    <h1>Tu Carrito de Compras</h1>
    <p><a href="productos.php">Volver a Productos</a></p>

    <?php if (isset($_SESSION['mensaje'])): ?>
        <p style="color: green; font-weight: bold;"><?php echo htmlspecialchars($_SESSION['mensaje']); ?></p>
        <?php unset($_SESSION['mensaje']); // Eliminar el mensaje después de mostrarlo ?>
    <?php endif; ?>

    <?php if (empty($_SESSION['carrito'])): ?>
        <p>El carrito está vacío.</p>
    <?php else: ?>
        <table border="1">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio Unitario</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['carrito'] as $id => $cantidad):
                    $producto = $productos[$id];
                    $subtotal = $producto['precio'] * $cantidad;
                    $total_compra += $subtotal;
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                        <td>$<?php echo htmlspecialchars(number_format($producto['precio'], 2)); ?></td>
                        <td><?php echo htmlspecialchars($cantidad); ?></td>
                        <td>$<?php echo htmlspecialchars(number_format($subtotal, 2)); ?></td>
                        <td>
                            <form method="POST" action="eliminar_del_carrito.php">
                                <input type="hidden" name="id_producto" value="<?php echo htmlspecialchars($id); ?>">
                                <button type="submit">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" align="right"><strong>TOTAL:</strong></td>
                    <td colspan="2"><strong>$<?php echo htmlspecialchars(number_format($total_compra, 2)); ?></strong></td>
                </tr>
            </tfoot>
        </table>

        <hr>
        <h2>Finalizar Compra</h2>
        <form method="POST" action="checkout.php">
            <label for="nombre_usuario">Tu Nombre (para recordarte):</label>
            <input type="text" id="nombre_usuario" name="nombre_usuario" required>
            <button type="submit">Proceder al Checkout</button>
        </form>

    <?php endif; ?>
</body>
</html>