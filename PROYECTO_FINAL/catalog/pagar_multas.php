<?php


require_once '../views/menu.php';
require_once 'ProjectManager.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


$pm = new ProjectManager();

if (isset($_GET['id'])) {
    $pm->payFine($_GET['id']);
    header("Location: mis_multas.php");
}
