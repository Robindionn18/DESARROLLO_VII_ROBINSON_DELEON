<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../ProjectManager.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

if (!isset($_GET['book_id'])) {
    header("Location: lista_libro.php");
    exit;
}

$pm = new ProjectManager();

$pm->reserveBook(
    $_SESSION['user_id'],
    $_GET['book_id'],
    date('Y-m-d H:i:s')
);

header("Location: mis_reservas.php");
exit;

