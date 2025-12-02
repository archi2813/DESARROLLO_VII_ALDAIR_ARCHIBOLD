<?php
require_once "config_pdo.php";
echo "Conexión exitosa a la base de datos con PDO.";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

$sql = "UPDATE productos SET nombre = :nombre, categoria = :categoria, precio = :precio, cantidad = :cantidad WHERE id = :id";

if($stmt = $pdo->prepare($sql)){
    // Asignamos los valores
    $stmt->bindParam(":nombre", $nombre);
    $stmt->bindParam(":categoria", $categoria);
    $stmt->bindParam(":precio", $precio);
    $stmt->bindParam(":cantidad", $cantidad);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);

    // Valores de ejemplo
    /*$nombre = "Roberto Gomez";
    $categoria = "avion";
    $precio = 250.75;
    $cantidad = 10;
    $id = 4;*/
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $categoria = $_POST['categoria'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];

    if (!isset($id)) {
        echo "ID no proporcionado.";
        exit;
    }
    if($stmt->execute()){
        echo "<br>";
        echo "Registro actualizado correctamente.";
    } else {
        echo "Error al actualizar el registro.";
    }
}
}
unset($stmt);
unset($pdo);

?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div><label>Numero ID a Editar</label><input type="integer" name="id" required></div>
    <div><label>Nombre</label><input type="text" name="nombre" required></div>
    <div><label>Categoria</label><input type="text" name="categoria" required></div>
    <div><label>Precio</label><input type="decimal" name="precio" required></div>
    <div><label>Cantigad</label><input type="integer" name="cantidad" required></div>
    <input type="submit" value="Editar Producto">
    <br>
    <a href="index.php">Mostrar tabla</a>
</form>