<?php
require 'db.php';
session_start();

// Verificar si es admin
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}

// Obtener todos los jugadores
$jugadores = $pdo->query("SELECT * FROM jugadores ORDER BY posicion, nombre")->fetchAll(PDO::FETCH_ASSOC);

$page_title = 'Admin Dashboard - Fantasy Fútbol';
include 'layout_head.php';
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-danger mb-4">
  <div class="container">
    <a href="admin_dashboard.php" class="navbar-brand"><i class="bi bi-shield-lock-fill me-2"></i>Panel Admin</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div id="mainNav" class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a href="admin_dashboard.php" class="nav-link active">Jugadores</a></li>
        <li class="nav-item"><a href="admin_logout.php" class="nav-link">Cerrar sesión</a></li>
      </ul>
    </div>
  </div>
</nav>

<main class="container">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-person-circle"></i> Gestión de Jugadores</h1>
    <a href="admin_crear.php" class="btn btn-success"><i class="bi bi-plus-circle"></i> Agregar Jugador</a>
  </div>

  <div class="card">
    <div class="card-body">
      <?php if (empty($jugadores)): ?>
        <div class="alert alert-info">
          No hay jugadores. <a href="admin_crear.php">Crear uno</a>
        </div>
      <?php else: ?>
        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead>
              <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Posición</th>
                <th>Equipo</th>
                <th>Precio</th>
                <th>Puntos</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($jugadores as $j): ?>
                <tr>
                  <td><?= $j['id'] ?></td>
                  <td><?= htmlspecialchars($j['nombre']) ?></td>
                  <td>
                    <span class="badge text-bg-secondary"><?= htmlspecialchars($j['posicion']) ?></span>
                  </td>
                  <td><?= htmlspecialchars($j['equipo']) ?></td>
                  <td>€<?= number_format($j['precio'], 2) ?></td>
                  <td><i class="bi bi-star-fill text-warning me-1"></i><?= $j['puntos'] ?></td>
                  <td>
                    <a href="admin_editar.php?id=<?= $j['id'] ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i> Editar</a>
                    <button type="button" class="btn btn-sm btn-danger eliminar-btn" data-id="<?= $j['id'] ?>" data-nombre="<?= htmlspecialchars($j['nombre']) ?>"><i class="bi bi-trash"></i> Eliminar</button>
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
$(document).on("click", ".eliminar-btn", function(){
    let id = $(this).data("id");
    let nombre = $(this).data("nombre");

    if(confirm("¿Estás seguro de que deseas eliminar a " + nombre + "?")) {
        $.post("admin_eliminar.php", { id: id }, function(res){
            if(res.ok) {
                alert("¡Jugador eliminado correctamente!");
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
