<?php
session_start();
require 'gestor_productos.php';


$gestor = new GestorProductos();
$products = $gestor->obtenerProductos();

//print_r($gestor);
// Inicializar carrito en sesión
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Manejo de acciones (add, remove, clear)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
        $qty = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
        //$gestor -> agregarProducto($id, $qty);
        
        if ($qty < 1) $qty = 1;
        if (isset($products[$id])) {
            if (!isset($_SESSION['cart'][$id])) {
                $_SESSION['cart'][$id] = 0;
            }
            $_SESSION['cart'][$id] += $qty;
        }
    } elseif ($action === 'remove') {
        $id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
        unset($_SESSION['cart'][$id]);
        
    } elseif ($action === 'clear') {
        $_SESSION['cart'] = [];
    }
}

?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Productos - Tienda</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
</head>
<body>
    <h1>Productos</h1>

    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th class="right">Precio ($)</th>
                <th class="right">Cantidad</th>
                <th class="right">Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $id => $p): ?>
            <tr>
                <td><?php echo htmlspecialchars($p['name']); ?></td>
                <td class="right"><?php echo number_format($p['price'], 2); ?></td>
                <td class="right">
                    <form class="inline" method="post" action="productos.php">
                        <input type="hidden" name="action" value="add">
                        <input type="hidden" name="product_id" value="<?php echo $id; ?>">
                        <input type="number" name="quantity" value="1" min="1" style="width:30px">
                        <button type="submit">Añadir al carrito</button>
                        </a>
                    </form>
                </td>
                <td class="right"><?php echo 'ID ' . $id; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="cart">
        <h2>Carrito</h2>
        <?php if (empty($_SESSION['cart'])): ?>
            <p>El carrito está vacío.</p>
        <?php else: ?>
            <form method="post" action="productos.php" class="inline">
                <input type="hidden" name="action" value="clear">
                <button type="submit">Vaciar carrito</button>
                <button formaction="ver_carrito.php" formmethod="get">Ver carrito</button>
            </form>
            <table style="margin-top:10px">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th class="right">Precio ($)</th>
                        <th class="right">Cantidad</th>
                        <th class="right">Total ($)</th>
                        <th class="right">Acción</th>
                    </tr>
                </thead>
                
            </table>
        <?php endif; ?>
    </div>
       <a href="logout.php">Cerrar Sesión</a>

</body>
</html>