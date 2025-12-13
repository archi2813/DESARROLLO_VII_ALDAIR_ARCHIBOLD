<?php
session_start();

if (!isset($_SESSION['user']) || !isset($_SESSION['user']['role']) || $_SESSION['user']['role'] !== 'estudiante') {
    header('Location: login.php');
    exit();
}


require_once __DIR__ . '/usuario.php';

$nombreEstudiante = $_SESSION['user']['usuario'];
$calificacion = 'No tiene calificación registrada';
foreach ($users as $u) {
    if (isset($u['usuario']) && strtolower($u['usuario']) === strtolower($nombreEstudiante)) {
        $calificacion = $u['nota'] ?? $calificacion;
        break;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Estudiante</title>
 </head>
<body>

<h2>Bienvenido Estudiante : <?php echo htmlspecialchars($nombreEstudiante); ?></h2>

<h3><?php echo htmlspecialchars($nombreEstudiante); ?> Tu calificación: <?php echo((string)$calificacion); ?></h3>

<br>
<a href="logout.php">Cerrar sesión</a>

</body>
</html>

