<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../views/menu.php';
require_once '../ProjectManager.php';


// Validar admin (ejemplo simple)
if ($_SESSION['role'] != 2) die("Acceso denegado");

$pm = new ProjectManager();

// Ver todas las multas
$stmt = $pm->getAllFines(); // lo agregamos abajo
?>

<h3>Gestión de Multas</h3>
<table border="1">
<tr>
    <th>Usuario</th>
    <th>Monto</th>
    <th>Motivo</th>
    <th>Estado</th>
</tr>

<?php foreach ($stmt as $m): ?>
<tr>
    <td><?= $m['user_id'] ?></td>
    <td>$<?= $m['fine_amount'] ?></td>
    <td><?= $m['reason'] ?></td>
    <td><?= $m['is_paid'] ? 'Pagada' : 'Pendiente' ?></td>
</tr>
<?php endforeach; ?>
</table>
