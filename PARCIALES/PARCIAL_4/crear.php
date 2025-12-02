<?php
require_once "config_pdo.php";
echo "Conexión exitosa a la base de datos con MySQLi.";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $nombre = $_POST['nombre'];
    $categoria = $_POST['categoria'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];
    $fecha_registro = date('Y-m-d H:i:s');
    
    $sql = "INSERT INTO productos (nombre, categoria, precio, cantidad, fecha_registro) VALUES (:nombre, :categoria, :precio, :cantidad, :fecha_registro)";
    
    if($stmt = $pdo->prepare($sql)){
        $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
        $stmt->bindParam(":categoria", $categoria, PDO::PARAM_STR);
        $stmt->bindParam(":precio", $precio, PDO::PARAM_STR);
        $stmt->bindParam(":cantidad", $cantidad, PDO::PARAM_INT);
        $stmt->bindParam(":fecha_registro", $fecha_registro, PDO::PARAM_STR);
        
        if($stmt->execute()){
            echo "producto creado con éxito.";
            echo "<br>";
        } else{
            echo "ERROR: No se pudo ejecutar $sql. " . $stmt->errorInfo()[2];
        }
    }
    
    unset($stmt);
}

unset($pdo);
?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div><label>Nombre</label><input type="text" name="nombre" required></div>
    <div><label>Categoria</label><input type="text" name="categoria" required></div>
    <div><label>Precio</label><input type="decimal" name="precio" required></div>
    <div><label>Cantigad</label><input type="integer" name="cantidad" required></div>
    <div><label>Fecha Registro</label><input type="date" name="fecha_registro" required></div>
    <input type="submit" value="Crear producto">
    <br>
    <a href="index.php">Mostrar tabla</a>
</form>
