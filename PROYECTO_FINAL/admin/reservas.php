<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../views/menu.php';
require_once '../ProjectManager.php';



$pm = new ProjectManager();
$reservas = $pm->getAllReservations();
?>

<h3>Reservas Pendientes</h3>

<?php foreach ($reservas as $r): ?>
    <?= $r['title'] ?> - <?= $r['first_name'] ?>
    <a href="aprobar.php?id=<?= $r['id'] ?>">Aprobar</a>
    <a href="cancelar.php?id=<?= $r['id'] ?>">Cancelar</a>
    <br>
<?php endforeach; ?>
