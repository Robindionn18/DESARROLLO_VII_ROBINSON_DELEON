<?php
include 'config_sesion.php'; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Productos</title>
</head>
<body>
    <h1>Nuestros Productos</h1>
    <p><a href="ver_carrito.php">Ver Carrito</a></p>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Producto</th>
                <th>Precio</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productos as $id => $producto): ?>
                <tr>
                    <td><?php echo htmlspecialchars($id); ?></td>
                    <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                    <td>$<?php echo htmlspecialchars(number_format($producto['precio'], 2)); ?></td>
                    <td>
                        <form method="POST" action="agregar_al_carrito.php">
                            <input type="hidden" name="id_producto" value="<?php echo htmlspecialchars($id); ?>">
                            <input type="number" name="cantidad" value="1" min="1" style="width: 50px;">
                            <button type="submit">Añadir</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php if (isset($_COOKIE['nombre_usuario'])): ?>
        <p>¡Bienvenido de nuevo, <?php echo htmlspecialchars($_COOKIE['nombre_usuario']); ?>!</p>
    <?php endif; ?>
</body>
</html>