
<?php
// Ejemplo de uso de explode()
$frase = "Manzana,Naranja,Plátano,Uva";
$frutas = explode(",", $frase);

echo "Frase original: $frase</br>";
echo "Array de frutas:</br>";
print_r($frutas);

// Ejercicio: Crea una variable con una lista de tus 5 películas favoritas separadas por guiones (-)
// y usa explode() para convertirla en un array
$misPeliculas = "kimetsu-ironMan-goku-vegetta-amores "; // Reemplaza esto con tu lista de películas
$arrayPeliculas = explode("-", $misPeliculas);

echo "</br>Mis películas favoritas:</br>";
print_r($arrayPeliculas);

// Bonus: Usa explode() con un límite
$texto = "Uno,Dos,Tres,Cuatro,Cinco";
$array = explode(",", $texto, 3);

echo "</br>Texto original: $texto</br>";
echo "Array con límite:</br>";
print_r($array);
echo"</br>";
$animes = "kimetsu naruto bleach onePiece yuyutsu";
$anime = explode(" ", $animes);
echo " Array de anime <br>";
print_r($anime);
?>
      
