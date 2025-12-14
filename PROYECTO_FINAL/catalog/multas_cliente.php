<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

require_once '../views/menu.php';
require_once '../ProjectManager.php';

$pm = new ProjectManager();
$multas = $pm->getUserFines($_SESSION['user_id']);
$total  = $pm->getTotalFines($_SESSION['user_id']);
?>


<h3>Mis Multas</h3>

<?php if ($total == 0): ?>
    <p>No tienes multas pendientes.</p>
<?php else: ?>
<table border="1" cellpadding="5">
<tr>
    <th>Motivo</th>
    <th>Monto</th>
    <th>Estado</th>
    <th>Acción</th>
</tr>

<?php foreach ($multas as $m): ?>
<tr>
    <td><?= $m['reason'] ?></td>
    <td>$<?= $m['fine_amount'] ?></td>
    <td>Pendiente</td>
    <td>
        <a href="pagar_multa.php?id=<?= $m['id'] ?>">Pagar</a>
    </td>
</tr>
<?php endforeach; ?>
</table>

<strong>Total: $<?= $total ?></strong>
<?php endif; ?>
