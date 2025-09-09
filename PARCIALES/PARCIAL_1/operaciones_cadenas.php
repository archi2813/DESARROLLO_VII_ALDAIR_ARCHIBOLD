<?php

function contar_palabras_repetidas($texto){
    $texto_minus = strtolower ($texto);
    //explode($texto);
    //trim($texto);
}


contar_palabras_repetidas("hola");

function capitalizar_palabras($texto){
   $palabras = explode(" ", strtolower($texto));
    $palabrasModificadas = array_map(function($palabra) {
        return strtoupper(substr($palabra, 0, 1)) . substr($palabra, 1);
    }, $palabras);
    return implode(" ", $palabrasModificadas);

}

$texto1 = "mi nombre es aldair archibold";
$fraseModificada = capitalizar_palabras($texto1);
echo "</br> $texto1</br>";
echo " $fraseModificada</br>";
?>