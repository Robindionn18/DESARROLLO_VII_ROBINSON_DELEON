<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


require_once '../ProjectManager.php';

$pm = new ProjectManager();
$pm->cancelReservation($_GET['id']);

header("Location: mis_reservas.php");
exit;