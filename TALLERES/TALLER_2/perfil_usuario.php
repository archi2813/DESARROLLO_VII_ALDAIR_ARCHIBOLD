<?php
$nombre_completo = "Aldair Isaac Archibold Mendez";
$edad = "29";
$correo = "aldair.archibold28@gmail.com";
$telefono = "61408747";
define("OCUPACION", "Desarrollador de software");


echo "Mi nombre es " . $nombre_completo . ", tengo " . $edad . " años, mi correo es " . $correo . ", mi teléfono es " . $telefono . " y mi ocupación actual es " . OCUPACION . ".";
echo "<br>";

print "<br>Mi nombre es $nombre_completo, tengo $edad años, mi correo es $correo, mi teléfono es $telefono y mi ocupación actual es " . OCUPACION . "";
 echo "<br>";

printf("<br>Mi nombre es $nombre_completo, tengo $edad años, mi correo es $correo, mi teléfono es $telefono y mi ocupación actual es " . OCUPACION . "");
echo "<br>";
var_dump($nombre_completo);
echo "<br>";
var_dump($edad);
echo "<br>";
var_dump($correo);
echo "<br>";
var_dump($telefono);
echo "<br>";
var_dump(OCUPACION);
?>