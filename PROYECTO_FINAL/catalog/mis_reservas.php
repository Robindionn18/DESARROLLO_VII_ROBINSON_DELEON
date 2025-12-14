<?php

require_once '../views/menu.php';
require_once '../ProjectManager.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


$pm = new ProjectManager();
$reservas = $pm->getUserReservations($_SESSION['user_id']);
?>

<h3>Mis Reservas</h3>

<?php foreach ($reservas as $r): ?>
    <?= $r['title'] ?>
    <a href="cancelar.php?id=<?= $r['id'] ?>">Cancelar</a>
    <br>
<?php endforeach; ?>
