<?php

$paginaActual = basename($_SERVER['PHP_SELF']);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<nav style="background:#333; padding:10px;">

    <?php if (!isset($_SESSION['user_id'])): ?>
        <!-- NO LOGUEADO -->
        <a href="/TALLERES/PROYECTO_FINAL/catalog/index.php" style="color:white; margin-right:15px;">Inicio</a>
        <a href="/TALLERES/PROYECTO_FINAL/login.php" style="color:white; margin-right:15px;">Login</a>
        <a href="/TALLERES/PROYECTO_FINAL/registro.php" style="color:white;">Registro</a>

    <?php else: ($_SESSION['role'] == 1)?>
        <!-- CLIENTE -->
        <a href="/TALLERES/PROYECTO_FINAL/catalog/lista_libro.php" style="color:white; margin-right:15px;">Catálogo</a>
        <a href="/TALLERES/PROYECTO_FINAL/catalog/mis_reservas.php" style="color:white; margin-right:15px;">Mis Reservas</a>
        <a href="/TALLERES/PROYECTO_FINAL/catalog/mis_prestamos.php" style="color:white; margin-right:15px;">Mis Préstamos</a>
        <a href="/TALLERES/PROYECTO_FINAL/catalog/multas_cliente.php" style="color:white; margin-right:15px;">Multas</a>

        <?php if ($_SESSION['role'] == 2): ?>
            <!-- ADMIN -->
            | 
            <a href="/TALLERES/PROYECTO_FINAL/admin/addBook.php" style="color:#00ffcc; margin-right:15px;">Libros</a>
            <a href="/TALLERES/PROYECTO_FINAL/admin/reservas.php" style="color:#00ffcc; margin-right:15px;">Reservas</a>
            <a href="/TALLERES/PROYECTO_FINAL/admin/multas.php" style="color:#00ffcc; margin-right:15px;">Multas</a>
        <?php endif; ?>

        <a href="/TALLERES/PROYECTO_FINAL/logout.php" style="color:red;">Salir</a>
    <?php endif; ?>
</nav>
