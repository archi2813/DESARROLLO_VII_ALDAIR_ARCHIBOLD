<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require 'db.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

// Obtener saldo
$stmt = $pdo->prepare("SELECT saldo FROM usuarios WHERE id = ?");
$stmt->execute([$usuario_id]);
$saldo = $stmt->fetchColumn();

// Obtener jugadores disponibles
$jugadores = $pdo->query("SELECT * FROM jugadores ORDER BY posicion")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Fantasy Fútbol</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="container py-4">

<h1>Fantasy Fútbol</h1>
<p><strong>Saldo:</strong> €<?= number_format($saldo, 2) ?></p>

<h2>Mercado de fichajes</h2>
<table class="table table-striped">
<thead>
<tr>
    <th>Jugador</th>
    <th>Posición</th>
    <th>Equipo</th>
    <th>Precio</th>
    <th>Puntos</th>
    <th>Acción</th>
</tr>
</thead>
<tbody>
<?php foreach ($jugadores as $j): ?>
<tr>
    <td><?= htmlspecialchars($j['nombre']) ?></td>
    <td><?= $j['posicion'] ?></td>
    <td><?= $j['equipo'] ?></td>
    <td>€<?= number_format($j['precio'], 2) ?></td>
    <td><?= $j['puntos'] ?></td>
    <td>
        <button class="btn btn-success btn-sm comprar" data-id="<?= $j['id'] ?>" data-precio="<?= $j['precio'] ?>">Comprar</button>
    </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<script>
$(document).on("click", ".comprar", function(){
    let jugadorId = $(this).data("id");
    let precio = $(this).data("precio");

    $.post("comprar.php", { jugador_id: jugadorId, precio: precio }, function(res){
        alert(res.mensaje);
        if(res.ok) location.reload();
    }, "json");
});
</script>

</body>
</html>
