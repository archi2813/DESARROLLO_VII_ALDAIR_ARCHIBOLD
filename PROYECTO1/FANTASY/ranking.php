<?php
require 'db.php';
session_start();

// Consulta para obtener puntajes totales por usuario
$sql = "
SELECT u.nombre AS usuario, e.nombre_equipo, 
       COALESCE(SUM(j.puntos), 0) AS total_puntos
FROM usuarios u
LEFT JOIN equipos e ON u.id = e.usuario_id
LEFT JOIN equipo_jugadores ej ON e.id = ej.equipo_id
LEFT JOIN jugadores j ON ej.jugador_id = j.id
GROUP BY u.id, e.id
ORDER BY total_puntos DESC
";

$stmt = $pdo->query($sql);
$ranking = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ranking de Usuarios</title>
    <style>
        table { border-collapse: collapse; width: 60%; margin: 20px auto; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
        th { background-color: #f4f4f4; }
    </style>
</head>
<body>
    <h1 style="text-align:center;">🏆 Ranking de Fantasy Fútbol</h1>
    <table>
        <tr>
            <th>Posición</th>
            <th>Usuario</th>
            <th>Equipo</th>
            <th>Puntos Totales</th>
        </tr>
        <?php 
        $posicion = 1;
        foreach ($ranking as $fila): ?>
        <tr>
            <td><?= $posicion++ ?></td>
            <td><?= htmlspecialchars($fila['usuario']) ?></td>
            <td><?= htmlspecialchars($fila['nombre_equipo'] ?? 'Sin equipo') ?></td>
            <td><?= $fila['total_puntos'] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
