<?php
require_once "config_pdo.php";

try {
    // Iniciamos transacción para que ambas operaciones sean seguras
    $pdo->beginTransaction();

    $id = 3; // Ejemplo: eliminar usuario con id 3

    //Eliminar publicaciones relacionadas
    $sqlPub = "DELETE FROM publicaciones WHERE usuario_id = :id";
    $stmtPub = $pdo->prepare($sqlPub);
    $stmtPub->bindParam(":id", $id, PDO::PARAM_INT);
    $stmtPub->execute();

    //Eliminar el usuario
    $sqlUser = "DELETE FROM usuarios WHERE id = :id";
    $stmtUser = $pdo->prepare($sqlUser);
    $stmtUser->bindParam(":id", $id, PDO::PARAM_INT);
    $stmtUser->execute();

    $pdo->commit();

    echo "Usuario y publicaciones eliminados correctamente.";

} catch (PDOException $e) {
    $pdo->rollBack();

    if ($e->getCode() == 23000) {
        echo " No se puede eliminar el usuario porque tiene relaciones activas.";
    } else {
        echo "Error: " . $e->getMessage();
    }
}

unset($stmtPub, $stmtUser);
unset($pdo);

?>