<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// PROTEGER ADMIN
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 2) {
    header("Location: ../catalog/index.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: reservas.php");
    exit;
}

require_once '../ProjectManager.php';

$pm = new ProjectManager();
$pm->cancelReservation($_GET['id']);

header("Location: reservas.php");
exit;