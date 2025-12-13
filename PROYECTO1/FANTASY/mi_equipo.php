
<?php
// mi_equipo.php
require 'db.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

$usuario_id = (int)$_SESSION['usuario_id'];

// 1) Obtener (o crear) equipo del usuario
$stmt = $pdo->prepare("SELECT id, nombre_equipo FROM equipos WHERE usuario_id = ?");
$stmt->execute([$usuario_id]);
$equipo = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$equipo) {
    // Si el usuario no tiene equipo aún, lo creamos para evitar errores
    $pdo->prepare("INSERT INTO equipos (usuario_id, nombre_equipo) VALUES (?, 'Mi Equipo')")
        ->execute([$usuario_id]);
    $equipo = [
        'id' => (int)$pdo->lastInsertId(),
        'nombre_equipo' => 'Mi Equipo',
    ];
}
$equipo_id = (int)$equipo['id'];

// 2) Traer jugadores del equipo con JOIN
$sql = "
SELECT j.id, j.nombre, j.posicion, j.equipo AS club, j.precio, j.puntos
FROM equipo_jugadores ej
JOIN jugadores j ON ej.jugador_id = j.id
WHERE ej.equipo_id = ?
ORDER BY j.posicion, j.nombre
";
$stmt = $pdo->prepare($sql);
$stmt->execute([$equipo_id]);
$misJugadores = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 3) Calcular totales
$totalPrecio = 0.0;
$totalPuntos = 0;
foreach ($misJugadores as $j) {
    $totalPrecio += (float)$j['precio'];
    $totalPuntos += (int)$j['puntos'];
}

// 4) Obtener saldo del usuario (opcional, para mostrar)
$stmtSaldo = $pdo->prepare("SELECT saldo FROM usuarios WHERE id = ?");
$stmtSaldo->execute([$usuario_id]);
$saldo = (float)$stmtSaldo->fetchColumn();

$page_title = 'Mi Equipo - Fantasy Fútbol';
include 'layout_head.php';
include 'navbar_user.php';
?>

<main class="container">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="page-title"><i class="bi bi-people-fill"></i> <?= htmlspecialchars($equipo['nombre_equipo']) ?></h1>
    <div class="d-flex gap-2">
      <span class="badge text-bg-success">Saldo: €<?= number_format($saldo, 2) ?></span>
    </div>
  </div>

  <!-- Resumen -->
  <div class="row stats g-3 mb-3">
    <div class="col-sm-6 col-lg-3">
      <div class="card p-3">
        <div class="text-muted small">Jugadores</div>
        <div class="fs-4 fw-bold"><?= count($misJugadores) ?></div>
      </div>
    </div>
    <div class="col-sm-6 col-lg-3">
      <div class="card p-3">
        <div class="text-muted small">Total invertido</div>
        <div class="fs-4 fw-bold">€<?= number_format($totalPrecio, 2) ?></div>
      </div>
    </div>
    <div class="col-sm-6 col-lg-3">
      <div class="card p-3">
        <div class="text-muted small">Puntos acumulados</div>
        <div class="fs-4 fw-bold"><?= (int)$totalPuntos ?></div>
      </div>
    </div>
    <div class="col-sm-6 col-lg-3">
      <a href="ranking.php" class="card p-3 text-decoration-none text-reset">
        <i class="bi bi-bar-chart-line me-2"></i> Ver ranking
      </a>
    </div>
  </div>

  <!-- Tabla de jugadores -->
  <div class="card">
    <div class="card-body">
      <h5 class="card-title mb-3">Mis jugadores</h5>

      <?php if (empty($misJugadores)): ?>
        <div class="alert alert-info">
          Aún no has comprado jugadores. Ve al <a href="dashboard.php">Mercado</a> para empezar.
        </div>
      <?php else: ?>
        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead>
              <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Posición</th>
                <th>Club</th>
                <th>Precio</th>
                <th>Puntos</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
            <?php $i = 1; foreach ($misJugadores as $j): ?>
              <tr>
                <td><?= $i++ ?></td>
                <td><?= htmlspecialchars($j['nombre']) ?></td>
                <td>
                  <span class="badge text-bg-secondary badge-pos"><?= htmlspecialchars($j['posicion']) ?></span>
                </td>
                <td><?= htmlspecialchars($j['club']) ?></td>
                <td>€<?= number_format((float)$j['precio'], 2) ?></td>
                <td><i class="bi bi-star-fill text-warning me-1"></i><?= (int)$j['puntos'] ?></td>
                <td>
                  <!-- Botón para vender con AJAX -->
                  <button type="button" class="btn btn-sm btn-outline-danger vender-btn" data-jugador-id="<?= (int)$j['id'] ?>" data-jugador-nombre="<?= htmlspecialchars($j['nombre']) ?>">
                    <i class="bi bi-trash"></i> Vender
                  </button>
                </td>
              </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>
  </div>
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).on("click", ".vender-btn", function(){
    let jugadorId = $(this).data("jugador-id");
    let jugadorNombre = $(this).data("jugador-nombre");
    let btn = $(this);

    if(confirm("¿Estás seguro de que deseas vender a " + jugadorNombre + "?")) {
        $.post("vender.php", { jugador_id: jugadorId }, function(res){
            if(res.ok) {
                alert("¡" + jugadorNombre + " vendido correctamente!");
                location.reload();
            } else {
                alert("Error: " + res.mensaje);
            }
        }, "json").fail(function() {
            alert("Error en la solicitud");
        });
    }
});
</script>

<?php include 'layout_foot.php'; ?>
