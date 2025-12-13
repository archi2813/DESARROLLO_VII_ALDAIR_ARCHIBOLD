<?php
require 'db.php';
session_start();

$title = 'Iniciar sesión';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT id, password_hash FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($password, $usuario['password_hash'])) {
        $_SESSION['usuario_id'] = (int)$usuario['id'];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Credenciales incorrectas";
    }
}
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($title) ?></title>
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
  <!-- App CSS -->
  <link href="assets/app.css" rel="stylesheet">
</head>
<body class="login-page">
  <!-- blobs decorativos -->
  <span class="blob one"></span>
  <span class="blob two"></span>
  <span class="blob three"></span>

  <div class="glass">
    <!-- Toggle tema -->
    <label class="theme-toggle">
      <input id="themeToggler" type="checkbox">
      <div class="switch"><div class="thumb"></div></div>
      <i class="bi bi-brightness-high"></i>
    </label>

    <!-- Marca -->
    <div class="brand">
      <div class="logo"><i class="bi bi-trophy-fill"></i></div>
      <div>
        <div class="title">Fantasy Fútbol</div>
        <div class="subtitle">Inicia sesión para continuar</div>
      </div>
    </div>

    <?php if ($error): ?>
      <div class="alert-soft"><i class="bi bi-exclamation-triangle-fill me-1"></i><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" autocomplete="off" novalidate>
      <div class="form-floating mb-3">
        <input type="email" class="form-control" id="email" name="email" placeholder="nombre@correo.com" required>
        <label for="email"><i class="bi bi-envelope me-1"></i> Email</label>
      </div>

      <div class="form-floating mb-3 position-relative">
        <input type="password" class="form-control" id="password" name="password" placeholder="Tu contraseña" required>
        <label for="password"><i class="bi bi-shield-lock me-1"></i> Contraseña</label>
        <button type="button" class="btn btn-sm btn-link position-absolute end-0 top-50 translate-middle-y me-2" id="togglePass" style="border-radius:10px; text-decoration: none; color: #6c757d; padding: 0.5rem;">
          <i class="bi bi-eye"></i>
        </button>
      </div>

      <button type="submit" class="btn-premium">
        <i class="bi bi-box-arrow-in-right"></i> Iniciar sesión
      </button>

      <a href="admin_login.php" class="btn btn-outline-secondary w-100 mt-2">
        <i class="bi bi-shield-lock"></i> Acceso Admin
      </a>
    </form>
  </div>

  <!-- JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  
</body>
</html>


