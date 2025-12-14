<?php

require_once '../views/menu.php';

require_once '../ProjectManager.php';
$pm = new ProjectManager();

$order = $_GET['order'] ?? 'id';
$books = $pm->sortBooksBy($order);
?>

<h2>Bienvenido a la Libreria</h2>


