<?php
require 'db.php';
session_start();

// Verificar si es admin
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    header('Location: admin_dashboard.php');
    exit;
}

// Obtener jugador
$stmt = $pdo->prepare("SELECT * FROM jugadores WHERE id = ?");
$stmt->execute([$id]);
$jugador = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$jugador) {
    header('Location: admin_dashboard.php');
    exit;
}

$errores = [];
$datos = $jugador;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos = [
        'nombre' => trim($_POST['nombre'] ?? ''),
        'posicion' => trim($_POST['posicion'] ?? ''),
        'equipo' => trim($_POST['equipo'] ?? ''),
        'precio' => (float)($_POST['precio'] ?? 0),
        'puntos' => (int)($_POST['puntos'] ?? 0),
    ];

    // Validaciones
    if (empty($datos['nombre'])) {
        $errores[] = 'El nombre es requerido';
    }
    if (empty($datos['posicion'])) {
        $errores[] = 'La posición es requerida';
    }
    if (empty($datos['equipo'])) {
        $errores[] = 'El equipo es requerido';
    }
    if ($datos['precio'] <= 0) {
        $errores[] = 'El precio debe ser mayor a 0';
    }

    if (empty($errores)) {
        $stmt = $pdo->prepare("UPDATE jugadores SET nombre = ?, posicion = ?, equipo = ?, precio = ?, puntos = ? WHERE id = ?");
        if ($stmt->execute([$datos['nombre'], $datos['posicion'], $datos['equipo'], $datos['precio'], $datos['puntos'], $id])) {
            header('Location: admin_dashboard.php?msg=Jugador actualizado correctamente');
            exit;
        } else {
            $errores[] = 'Error al actualizar el jugador';
        }
    }
}

$page_title = 'Editar Jugador - Fantasy Fútbol';
include 'layout_head.php';
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-danger mb-4">
  <div class="container">
    <a href="admin_dashboard.php" class="navbar-brand"><i class="bi bi-shield-lock-fill me-2"></i>Panel Admin</a>
  </div>
</nav>

<main class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-body">
          <h2 class="mb-4"><i class="bi bi-pencil-square"></i> Editar Jugador</h2>

          <?php if (!empty($errores)): ?>
            <div class="alert alert-danger" role="alert">
              <ul class="mb-0">
                <?php foreach ($errores as $error): ?>
                  <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endif; ?>

          <form method="POST">
            <div class="mb-3">
              <label for="nombre" class="form-label">Nombre del Jugador</label>
              <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($datos['nombre']) ?>" required>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="posicion" class="form-label">Posición</label>
                  <select class="form-select" id="posicion" name="posicion" required>
                    <option value="">Selecciona una posición</option>
                    <option value="Portero" <?= $datos['posicion'] === 'Portero' ? 'selected' : '' ?>>Portero</option>
                    <option value="Defensa" <?= $datos['posicion'] === 'Defensa' ? 'selected' : '' ?>>Defensa</option>
                    <option value="Centrocampista" <?= $datos['posicion'] === 'Centrocampista' ? 'selected' : '' ?>>Centrocampista</option>
                    <option value="Delantero" <?= $datos['posicion'] === 'Delantero' ? 'selected' : '' ?>>Delantero</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="equipo" class="form-label">Equipo</label>
                  <input type="text" class="form-control" id="equipo" name="equipo" value="<?= htmlspecialchars($datos['equipo']) ?>" required>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="precio" class="form-label">Precio (€)</label>
                  <input type="number" class="form-control" id="precio" name="precio" step="0.01" value="<?= $datos['precio'] ?>" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="puntos" class="form-label">Puntos</label>
                  <input type="number" class="form-control" id="puntos" name="puntos" value="<?= $datos['puntos'] ?>">
                </div>
              </div>
            </div>

            <div class="d-flex gap-2">
              <button type="submit" class="btn btn-warning"><i class="bi bi-check-circle"></i> Guardar Cambios</button>
              <a href="admin_dashboard.php" class="btn btn-secondary"><i class="bi bi-x-circle"></i> Cancelar</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</main>

<?php include 'layout_foot.php'; ?>
