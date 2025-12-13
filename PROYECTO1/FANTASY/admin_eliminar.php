<?php
require 'db.php';
session_start();
header('Content-Type: application/json; charset=utf-8');

// Verificar si es admin
if (!isset($_SESSION['admin_id'])) {
    echo json_encode(['ok' => false, 'mensaje' => 'No autenticado']);
    exit;
}

$id = (int)($_POST['id'] ?? 0);

if ($id <= 0) {
    echo json_encode(['ok' => false, 'mensaje' => 'ID inválido']);
    exit;
}

try {
    $pdo->beginTransaction();

    // Verificar que el jugador existe
    $stmt = $pdo->prepare("SELECT id FROM jugadores WHERE id = ?");
    $stmt->execute([$id]);
    if (!$stmt->fetch()) {
        $pdo->rollBack();
        echo json_encode(['ok' => false, 'mensaje' => 'Jugador no encontrado']);
        exit;
    }

    // Eliminar el jugador
    $stmt = $pdo->prepare("DELETE FROM jugadores WHERE id = ?");
    $stmt->execute([$id]);

    // Eliminar referencias en equipos
    $stmt = $pdo->prepare("DELETE FROM equipo_jugadores WHERE jugador_id = ?");
    $stmt->execute([$id]);

    $pdo->commit();
    echo json_encode(['ok' => true, 'mensaje' => 'Jugador eliminado correctamente']);
} catch (Exception $e) {
    $pdo->rollBack();
    echo json_encode(['ok' => false, 'mensaje' => 'Error: ' . $e->getMessage()]);
}
