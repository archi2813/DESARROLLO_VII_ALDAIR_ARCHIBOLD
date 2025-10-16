<?php
session_start();
require 'gestor_productos.php';

// Manejar acción de vaciar carrito
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'clear') {
    $_SESSION['cart'] = [];
    header('Location: ver_carrito.php');
    exit;
}

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ver Carrito</title>
</head>
<body>
    <h2>Carrito de Compras</h2>
    <?php
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        echo "<p>El carrito está vacío.</p>";
    } else {
        echo "<table>";
        echo "<tr><th>Producto ID</th><th>Cantidad</th></tr>";
        foreach ($_SESSION['cart'] as $nombre => $quantity) {
            echo "<tr><td>" . htmlspecialchars($nombre) . "</td><td>" . (int)$quantity . "</td></tr>";
        }
        echo "</table>";

        // Formulario para vaciar carrito
        echo '<form method="post" style="margin-top:10px;">
                <input type="hidden" name="action" value="clear">
                <button type="submit">Vaciar carrito</button>
              </form>';
    }
    ?>
    <a href="productos.php">Volver a Productos</a>
    <br><br>
    <a href="logout.php">Cerrar Sesión</a>
</body>
</html>
<?php
session_write_close();