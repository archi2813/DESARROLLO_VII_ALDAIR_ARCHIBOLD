<?php

require_once "config_pdo.php";
echo "Conexión exitosa a la base de datos con PDO.";

$sql = "SELECT id, nombre, categoria, precio, cantidad, fecha_registro FROM productos";
// Preparar la declaración
if($stmt = $pdo->prepare($sql)){
    if($stmt->execute()){
        if($stmt->rowCount() > 0){
            echo "<table>";
                echo "<tr>";
                    echo "<th>ID</th>";
                    echo "<th>Nombre</th>";
                    echo "<th>Categoria</th>";
                    echo "<th>Precio</th>";
                    echo "<th>Cantidad</th>";
                    echo "<th>Fecha de Registro</th>";
                echo "</tr>";
            while($row = $stmt->fetch()){
                echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['nombre'] . "</td>";
                    echo "<td>" . $row['categoria'] . "</td>";
                    echo "<td>" . $row['precio'] . "</td>";
                    echo "<td>" . $row['cantidad'] . "</td>";
                    echo "<td>" . $row['fecha_registro'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else{
            echo "No se encontraron registros.";
        }
    } else{
        echo "ERROR: No se pudo ejecutar $sql. " . $stmt->errorInfo()[2];
    }
}

unset($stmt);
unset($pdo);
?>
<a href="crear.php">Crear Nuevo Producto</a>
<br>
<a href="editar.php">Editar Registro</a>
<br>
<a href="eliminar.php">Eliminar Registro</a>