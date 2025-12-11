<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


require 'db.php';
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(["ok" => false, "mensaje" => "No autenticado"]);
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$jugador_id = intval($_POST['jugador_id']);
$precio = floatval($_POST['precio']);

// Verificar saldo
$stmt = $pdo->prepare("SELECT saldo FROM usuarios WHERE id = ?");
$stmt->execute([$usuario_id]);
$saldo = $stmt->fetchColumn();

if ($saldo < $precio) {
    echo json_encode(["ok" => false, "mensaje" => "Saldo insuficiente"]);
    exit;
}

// Obtener equipo del usuario
$stmt = $pdo->prepare("SELECT id FROM equipos WHERE usuario_id = ?");
$stmt->execute([$usuario_id]);
$equipo_id = $stmt->fetchColumn();

if (!$equipo_id) {
    // Crear equipo si no existe
    $pdo->prepare("INSERT INTO equipos (usuario_id, nombre_equipo) VALUES (?, 'Mi Equipo')")
        ->execute([$usuario_id]);
    $equipo_id = $pdo->lastInsertId();
}

// Insertar jugador en equipo
try {
    $pdo->prepare("INSERT INTO equipo_jugadores (equipo_id, jugador_id) VALUES (?, ?)")
        ->execute([$equipo_id, $jugador_id]);

    // Descontar saldo
    $pdo->prepare("UPDATE usuarios SET saldo = saldo - ? WHERE id = ?")
        ->execute([$precio, $usuario_id]);

    echo json_encode(["ok" => true, "mensaje" => "Jugador comprado con éxito"]);
} catch (PDOException $e) {
    echo json_encode(["ok" => false, "mensaje" => "Ya tienes este jugador"]);
}
?>
