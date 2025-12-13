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

$page_title = 'Ranking - Fantasy Fútbol';
include 'layout_head.php';
include 'navbar_user.php';
?>

<main class="container">
  <h1 class="page-title mb-4"><i class="bi bi-bar-chart-line"></i> Ranking de Fantasy Fútbol</h1>
  
  <div class="card">
      <div class="table-responsive">
        <table class="table table-hover align-middle">
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
      </div>
    </div>
  </div>
</main>

<?php include 'layout_foot.php'; ?>