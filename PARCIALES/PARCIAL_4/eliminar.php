<?php
require_once "config_pdo.php";
echo "Conexión exitosa a la base de datos con PDO.";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

try {
    // Iniciamos transacción para que ambas operaciones sean seguras
    $pdo->beginTransaction();

    //$id = 3; // Ejemplo: eliminar usuario con id 3

    //Eliminar publicaciones relacionadas
    $sqlPub = "DELETE FROM productos WHERE id = :id";
    $stmtPub = $pdo->prepare($sqlPub);
    $stmtPub->bindParam(":id", $id, PDO::PARAM_INT);
    $stmtPub->execute();

    //Eliminar el usuario
    $sqlUser = "DELETE FROM productos WHERE id = :id";
    $stmtUser = $pdo->prepare($sqlUser);
    $stmtUser->bindParam(":id", $id, PDO::PARAM_INT);
    $stmtUser->execute();

    $pdo->commit();
    echo "<br>";
    echo "producto eliminados correctamente.";

} catch (PDOException $e) {
    $pdo->rollBack();

    if ($e->getCode() == 23000) {
        echo " No se puede eliminar el usuario porque tiene relaciones activas.";
    } else {
        echo "Error: " . $e->getMessage();
    }
}
}
unset($stmtPub, $stmtUser);
unset($pdo);

?>
<br>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div><label>Numero ID a Eliminar</label><input type="integer" name="id" required></div>
    <input type="submit" value="Eliminar Producto">
    <br>
    <a href="index.php">Mostrar tabla</a>
</form>
