<?php
require_once  "config_pdo.php";

$sql = "UPDATE usuarios SET nombre = :nombre, email = :email WHERE id = :id";

if($stmt = $pdo->prepare($sql)){
    // Asignamos los valores
    $stmt->bindParam(":nombre", $nombre);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);

    // Valores de ejemplo
    $nombre = "Roberto Gomez";
    $email = "Aldair_archibold@email.com";
    $id = 1;

    if($stmt->execute()){
        echo "Registro actualizado correctamente.";
    } else {
        echo "Error al actualizar el registro.";
    }
}
unset($stmt);
unset($pdo);

?>