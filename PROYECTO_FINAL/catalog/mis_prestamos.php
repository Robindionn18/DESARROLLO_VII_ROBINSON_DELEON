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

<?php foreach ($loans as $loan): ?>
    <strong><?= $loan['title'] ?></strong><br>
    Fecha devolución: <?= $loan['due_date'] ?><br>
    <a href="devolver.php?id=<?= $loan['id'] ?>">Devolver</a>
    <hr>
<?php endforeach; ?>
