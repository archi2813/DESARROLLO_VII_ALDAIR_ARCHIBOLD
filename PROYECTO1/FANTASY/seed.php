
<?php
require 'db.php';

$updates = [
    ['email' => 'juan.perez@example.com',    'password' => 'Juan123!'],
    ['email' => 'maria.lopez@example.com',   'password' => 'Maria123!'],
    ['email' => 'carlos.gomez@example.com',  'password' => 'Carlos1$'],
    ['email' => 'ana.torres@example.com',    'password' => 'Ana#2025'],
    ['email' => 'luis.fernandez@example.com','password' => 'Luis_abc'],
];

$stmt = $pdo->prepare("UPDATE usuarios SET password_hash = :hash WHERE email = :email");

foreach ($updates as $u) {
    $hash = password_hash($u['password'], PASSWORD_DEFAULT);
    $stmt->execute([':hash' => $hash, ':email' => strtolower($u['email'])]);
}

echo "Contraseñas actualizadas con hash.\n";
?>