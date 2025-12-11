<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require 'db.php';

// Ejemplo: sumar puntos aleatorios (en producción usar API real)
$jugadores = $pdo->query("SELECT id FROM jugadores")->fetchAll(PDO::FETCH_ASSOC);

foreach ($jugadores as $j) {
    $puntos = rand(0, 10); // Simulación
    $pdo->prepare("UPDATE jugadores SET puntos = puntos + ? WHERE id = ?")
        ->execute([$puntos, $j['id']]);
}

echo "Puntos actualizados correctamente.";
?>