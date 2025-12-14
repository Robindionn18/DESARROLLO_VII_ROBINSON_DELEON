<?php


require_once '../views/menu.php';
require_once 'ProjectManager.php';
$pm = new ProjectManager();

echo $pm->getReturnStatus($_GET['loan_id']);
