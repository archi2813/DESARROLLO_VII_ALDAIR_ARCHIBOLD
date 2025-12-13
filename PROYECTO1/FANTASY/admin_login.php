<?php
session_start();

// Si ya está logueado como admin, redirigir al panel
if (isset($_SESSION['admin_id'])) {
    header('Location: admin_dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Credenciales de admin (cambiar en producción)
    $admin_usuario = 'admin';
    $admin_password = 'admin123'; // En producción: password_hash()

    if ($usuario === $admin_usuario && $password === $admin_password) {
        $_SESSION['admin_id'] = 1;
        $_SESSION['admin_usuario'] = $admin_usuario;
        header('Location: admin_dashboard.php');
        exit;
    } else {
        $error = 'Usuario o contraseña incorrectos';
    }
}

$page_title = 'Admin Login - Fantasy Fútbol';
include 'layout_head.php';
?>

<main class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body p-5">
          <h1 class="text-center mb-4"><i class="bi bi-lock-fill"></i> Panel de Admin</h1>
          
          <?php if ($error): ?>
            <div class="alert alert-danger" role="alert">
              <?= htmlspecialchars($error) ?>
            </div>
          <?php endif; ?>

          <form method="POST">
            <div class="mb-3">
              <label for="usuario" class="form-label">Usuario</label>
              <input type="text" class="form-control" id="usuario" name="usuario" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Contraseña</label>
              <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
          </form>

          <hr>
          <p class="text-center text-muted small">
            <a href="login.php">Volver al login de usuario</a>
          </p>
        </div>
      </div>
    </div>
  </div>
</main>

<?php include 'layout_foot.php'; ?>
