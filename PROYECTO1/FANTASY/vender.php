
<?php
// vender.php
require 'db.php';
session_start();
header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['ok' => false, 'mensaje' => 'No autenticado']);
    exit;
}

$usuario_id = (int)$_SESSION['usuario_id'];
$jugador_id = isset($_POST['jugador_id']) ? (int)$_POST['jugador_id'] : 0;

if ($jugador_id <= 0) {
    echo json_encode(['ok' => false, 'mensaje' => 'Datos inválidos']);
    exit;
}

try {
    $pdo->beginTransaction();

    // Equipo del usuario
    $stmt = $pdo->prepare("SELECT id FROM equipos WHERE usuario_id = ?");
    $stmt->execute([$usuario_id]);
    $equipo_id = (int)$stmt->fetchColumn();
    if (!$equipo_id) {
        $pdo->rollBack();
        echo json_encode(['ok' => false, 'mensaje' => 'No tienes equipo']);
        exit;
    }

    // Precio del jugador
    $stmt = $pdo->prepare("SELECT precio FROM jugadores WHERE id = ?");
    $stmt->execute([$jugador_id]);
    $precio = (float)$stmt->fetchColumn();
    if ($precio <= 0) { $precio = 0; }

    // Eliminar relación
    $stmt = $pdo->prepare("DELETE FROM equipo_jugadores WHERE equipo_id = ? AND jugador_id = ?");
    $stmt->execute([$equipo_id, $jugador_id]);
    if ($stmt->rowCount() === 0) {
        $pdo->rollBack();
        echo json_encode(['ok' => false, 'mensaje' => 'Ese jugador no está en tu equipo']);
        exit;
    }

    // Devolver saldo (ajusta la política si quieres comisión)
    $stmt = $pdo->prepare("UPDATE usuarios SET saldo = saldo + ? WHERE id = ?");
    $stmt->execute([$precio, $usuario_id]);

    $pdo->commit();
    echo json_encode(['ok' => true, 'mensaje' => 'Jugador vendido con éxito', 'saldo_devuelto' => $precio]);
} catch (Throwable $e) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    // Log interno
    error_log('Vender error: ' . $e->getMessage());
    echo json_encode(['ok' => false, 'mensaje' => 'Error al vender']);
}
?>