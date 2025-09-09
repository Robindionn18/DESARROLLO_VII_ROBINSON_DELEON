<?php

//Contar palabras repetidas

function contar_palabras_repetidas($texto) {
$textoMinusculas = strtolower($texto);
$textoMinusculas = trim($textoMinusculas);   
$frase_array = explode(" ", $textoMinusculas);

}


//Capitalizar palabras

function capitalizar_palabras($texto) {
    $TextoCantidad = strlen($texto);
    $TextoMayuscula = strtoupper($texto);
}



?>