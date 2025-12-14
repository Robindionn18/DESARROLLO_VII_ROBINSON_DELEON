<?php

require_once '../views/menu.php';

require_once 'ProjectManager.php';


$pm = new ProjectManager();

if (isset($_GET['id'])) {
    $pm->returnBook($_GET['id']);
    header("Location: mis_prestamos.php");
}
