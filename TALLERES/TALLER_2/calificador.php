<?php
// Declarar una calificación numérica
$calificacion = 72; // Puedes cambiar el número entre 0 y 100

// Determinar la letra usando if-elseif-else
if ($calificacion >= 90 && $calificacion <= 100) {
    $letra = "A";
} elseif ($calificacion >= 80 && $calificacion <= 89) {
    $letra = "B";
} elseif ($calificacion >= 70 && $calificacion <= 79) {
    $letra = "C";
} elseif ($calificacion >= 60 && $calificacion <= 69) {
    $letra = "D";
} elseif ($calificacion >= 0 && $calificacion <= 59) {
    $letra = "F";
} else {
    $letra = "Calificación inválida";
}

// Imprimir mensaje base
echo "Tu calificación es $letra. ";

// Usar operador ternario para aprobado o reprobado
echo ($letra !== "F") ? "Aprobado<br>" : "Reprobado<br>";

// Usar switch para mensaje adicional según la letra
switch ($letra) {
    case "A":
        echo "Excelente trabajo";
        break;
    case "B":
        echo "Buen trabajo";
        break;
    case "C":
        echo "Trabajo aceptable";
        break;
    case "D":
        echo "Necesitas mejorar";
        break;
    case "F":
        echo "Debes esforzarte más";
        break;
    default:
        echo "No se puede asignar un mensaje a esta calificación.";
        break;
}
?>