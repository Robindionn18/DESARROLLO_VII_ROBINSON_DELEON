<?php

//variables definidas 

$nombre = "Robinson De León";
$edad = 23;
$correo = "robinson.deleon@utp.ac.pa";
$telefono = "6385-4837";

//constante definida

define("OCUPACION","Estudiante");

//Mensaje

$mensaje = "Mi nombre es $nombre, tengo $edad años, mi correo es $correo, y mi telefono es $telefono";

echo $mensaje . "<br>";
print($mensaje . "<br>");
printf("Soy %s, con %d años, correo: %s, numero; %s, y soy un %s<br>", $nombre, $edad, $correo, $telefono, OCUPACION);

//Variable usadas

echo "<br>Información de debugging:<br>";
var_dump($nombre);
echo "<br>";
var_dump($edad);
echo "<br>";
var_dump($correo);
echo "<br>";
var_dump($telefono);
echo "<br>";
var_dump(OCUPACION);
echo "<br>";

//

?>