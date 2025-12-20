<?php
require_once '../views/menu.php';
require_once '../ProjectManager.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pm = new ProjectManager();
$multas = $pm->getAllFines();
?>

<h3>Gestión de Multas</h3>

<?php if (empty($multas)): ?>
    <p>No hay multas registradas.</p>
<?php else: ?>

<table border="1">
<tr>
    <th>Usuario</th>
    <th>Libro</th>
    <th>Monto</th>
    <th>Motivo</th>
    <th>Estado</th>
</tr>

<?php foreach ($multas as $m): ?>
<tr>
    <td><?= $m['first_name'] . ' ' . $m['last_name'] ?></td>
    <td><?= $m['title'] ?? 'Libro eliminado' ?></td>
    <td>$<?= $m['fine_amount'] ?></td>
    <td><?= $m['reason'] ?></td>
    <td><?= $m['status'] === 'paid' ? 'Pagada' : 'Pendiente' ?></td>
</tr>
<?php endforeach; ?>

</table>
<?php endif; ?>

