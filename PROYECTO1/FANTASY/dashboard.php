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

$page_title = 'Fantasy Fútbol - Mercado';
include 'layout_head.php';
include 'navbar_user.php';
?>

<main class="container">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title"><i class="bi bi-shop"></i> Mercado de fichajes</h1>
    <div>
      <span class="badge text-bg-success">Saldo: €<?= number_format($saldo, 2) ?></span>
    </div>
  </div>
  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover align-middle">
<thead>
<tr>
    <th>Jugador</th>
    <th>Posición</th>
    <th>Equipo</th>
    <th>Precio</th>
    <th class="d-none">Puntos</th>
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
    <td class="d-none"><?= $j['puntos'] ?></td>
    <td>
        <button class="btn btn-success btn-sm comprar" data-id="<?= $j['id'] ?>" data-precio="<?= $j['precio'] ?>">Comprar</button>
    </td>
</tr>
<?php endforeach; ?>
</tbody>
        </table>
      </div>
    </div>
  </div>
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

<?php include 'layout_foot.php'; ?>
