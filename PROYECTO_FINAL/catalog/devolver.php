<?php
 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

if (!isset($_POST['id'])) {
    header("Location: mis_prestamos.php");
    exit;
}

require_once '../ProjectManager.php';

$pm = new ProjectManager();
$pm->returnBook($_POST['id']);

header("Location: mis_prestamos.php");
exit;

