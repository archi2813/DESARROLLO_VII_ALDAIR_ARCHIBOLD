<?php
session_start();


if (!isset($_SESSION['user']) || !isset($_SESSION['user']['role']) || $_SESSION['user']['role'] !== 'profesor') {
    header('Location: login.php');
    exit();
}

require_once __DIR__ . '/usuario.php';

$profesorNombre = $_SESSION['user']['usuario'];
$estudiantes = [];
foreach ($users as $u) {
    if (isset($u['role']) && $u['role'] === 'estudiante') {
        $estudiantes[$u['usuario']] = $u['nota'] ?? 'Sin nota';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Profesor</title>
 </head>
<body>

<h2>Bienvenido Profesor: <?php echo htmlspecialchars($profesorNombre); ?></h2>

<h3>Lista de Estudiantes y Calificaciones</h3>

<table>
    <tr>
        <th>Estudiante</th>
        <th>Calificación</th>
    </tr>

    <?php foreach ($estudiantes as $nombre => $nota): ?>
    <tr>
        <td><?php echo htmlspecialchars($nombre); ?></td>
        <td><?php echo((string)$nota); ?></td>
    </tr>
    <?php endforeach; ?>

    <?php if (empty($estudiantes)): ?>
    <tr><td colspan="2">No hay estudiantes registrados.</td></tr>
    <?php endif; ?>

</table>
<br>
<a href="logout.php">Cerrar sesión</a>
</body>
</html>
