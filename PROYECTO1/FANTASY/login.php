<?php
require 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($password, $usuario['password_hash'])) {
        $_SESSION['usuario_id'] = $usuario['id'];
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Credenciales incorrectas";
    }
}
?>
<form method="POST">
    Email: <input type="email" name="email" required><br>
    Contraseña: <input type="password" name="password" required><br>
    <button type="submit">Iniciar sesión</button>
</form>
