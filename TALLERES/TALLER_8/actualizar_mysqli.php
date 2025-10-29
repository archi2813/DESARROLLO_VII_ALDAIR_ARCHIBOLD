<?php
require_once "config_mysqli.php";

$sql = "UPDATE usuarios SET nombre = ?, email = ? WHERE id = ?";

if($stmt = mysqli_prepare($conn, $sql)){
    mysqli_stmt_bind_param($stmt, "ssi", $nombre, $email, $id);

    
    $nombre = "Raul Rodriguez";
    $email = "roberta@gmail.com";
    $id = 1;

    if(mysqli_stmt_execute($stmt)){
        echo "Registro actualizado correctamente.";
    } else {
        echo "Error al actualizar el registro: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
} else {
    echo "Error preparando la consulta: " . mysqli_error($conn);
}

mysqli_close($conn);
?>