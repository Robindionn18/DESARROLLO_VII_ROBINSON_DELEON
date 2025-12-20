<?php

require_once '../views/menu.php';

require_once '../ProjectManager.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


$pm = new ProjectManager();
$loans = $pm->getActiveLoansByUser($_SESSION['user_id']);
?>

<h3>Mis Préstamos</h3>

<table border="1">
<tr>
    <th>Libro</th>
    <th>Fecha Préstamo</th>
    <th>Fecha Devolución</th>
    <th>Acción</th>
</tr>

<?php foreach ($loans as $l): ?>
<tr>
    <td><?= $l['title'] ?></td>
    <td><?= $l['lend_date'] ?></td>
    <td><?= $l['due_date'] ?></td>
    <td>
        <?php if ($l['status'] == 'active'): ?>
            <form method="post" action="devolver.php">
                <input type="hidden" name="id" value="<?= $l['id'] ?>">
                <button type="submit">Devolver</button>
            </form>
        <?php else: ?>
            Devuelto
        <?php endif; ?>
    </td>
</tr>
<?php endforeach; ?>
</table>
