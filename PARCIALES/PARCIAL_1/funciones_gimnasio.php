<?php
function calcular_promocion($antiguedad){
    if ($antiguedad < 3) {
    echo "No hay promocion.<br>";
} elseif ($antiguedad == 3 || $antiguedad <= 12) {
    echo "aplicar un descuento de 8%.<br>";
} elseif ($antiguedad == 13 || $antiguedad <= 24) {
    echo "Aplica un descuento de 12%.<br>";
} elseif ($antiguedad >= 24) {
   echo "Aplica un descuento de 20%.<br>";
}
return $antiguedad;
}
calcular_promocion(25);
echo "<BR>";
echo "<BR>";

function calcular_seguro_medico($cuota_base){
    return $cuota_base * 0.05;
}

echo"La cuota del 5% de mi seguro es: ". calcular_seguro_medico (800) . "<BR>";


function calcular_cuota_final($cuota_base,$descuento_porcentaje,$seguro_medico){
    $final = $cuota_base * $descuento_porcentaje / 100;
    $final2 = $cuota_base - $descuento_porcentaje + $seguro_medico;
    return $final2;
}
echo"<br>";
echo"La cuota final es ". calcular_cuota_final(50,20,500) . "<BR>"; 
?>