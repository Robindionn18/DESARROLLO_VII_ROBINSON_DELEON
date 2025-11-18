<?php
session_start();
session_destroy();
header("Location: cookies.php");
exit();
echo "Sesión cerrada.";
?>