<?php
session_start();
require_once 'usuario.php';

if(isset($_SESSION['usuario'])) {
    header("Location: panel_profesor.php");
    exit();
}

if(isset($_SESSION['usuario'])) {
    header("Location: panel_estudiante.php");
    exit();
}

$error = [];
$usuario = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $contrasena = $_POST['contrasena'] ?? '';

    if (strlen($usuario) < 3) {
        $error[] = "El nombre de usuario debe tener al menos 3 caracteres.";
    }
    if (!preg_match('/^[a-zA-Z0-9]+$/', $usuario)) {
        $error[] = "El nombre de usuario solo puede contener letras y números.";
    }

    if (strlen($contrasena) < 5) {
        $error[] = "La contraseña debe tener al menos 5 caracteres.";
    }

    if (empty($error)) {
        
        $busca = null;
        foreach ($users as $u) {
            if (strtolower($u['usuario']) === strtolower($usuario)) {
                $busca = $u;
                break;
            }
        }

        if ($busca && password_verify($contrasena, $busca['contrasena'])) {
            $_SESSION['user'] = [
                'usuario' => $busca['usuario'],
                'role' => $busca['role']
            ];
            if ($busca['role'] === 'estudiante' && isset($busca['nota'])) {
                $_SESSION['user']['nota'] = $busca['nota'];
            }
            if ($busca['role'] === 'profesor') {
                header('Location: panel_profesor.php');
                exit;
            } else {
                header('Location: panel_estudiante.php');
                exit;
            }
        } else {
            $error[] = "Usuario o contraseña incorrectos.";
        }
    }
}
?>
<!doctype html>
<html lang="es">
<head>
<title>Login - Sistema de calificaciones</title>
</head>
<body>
<div class="container">
    <h2>Iniciar sesión</h2>

    <?php if (!empty($error)): ?>
        <div class="error">
            <ul>
                <?php foreach ($error as $e): ?>
                    <li><?php echo htmlspecialchars($e); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" action="login.php" novalidate>
        <label>Nombre de usuario
            <input type="text" name="usuario" value="<?php echo htmlspecialchars($usuario); ?>" required>
        </label>
        <label>Contraseña
            <input type="password" name="contrasena" required>
        </label>
        <button type="submit">Entrar</button>
    </form>

</div>
</body>
</html>