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

<table border="1">
<tr>
    <th>Libro</th>
    <th>Motivo</th>
    <th>Monto</th>
    <th>Acción</th>
</tr>

<?php if (!empty($multas)): ?>
<?php foreach ($multas as $m): ?>
<tr>
    <td><?= $m['title'] ?? 'Libro eliminado' ?></td>
    <td><?= $m['reason'] ?></td>
    <td>$<?= $m['fine_amount'] ?></td>
    <td>
        <form method="post" action="pagar_multas.php">
            <input type="hidden" name="id" value="<?= $m['id'] ?>">
            <button type="submit">Pagar</button>
        </form>
    </td>
</tr>
<?php endforeach; ?>
<?php endif; ?>

</table>

<p><strong>Total a pagar:</strong> $<?= $total ?></p>

<?php endif; ?>

