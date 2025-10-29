<?php
require_once "config_pdo.php";

try {
    // 1. Mostrar todos los usuarios junto con el número de publicaciones que han hecho
    $sql = "SELECT u.id, u.nombre, COUNT(p.id) as num_publicaciones 
            FROM usuarios u 
            LEFT JOIN publicaciones p ON u.id = p.usuario_id 
            GROUP BY u.id";

    $stmt = $pdo->query($sql);

    echo "<h3>Usuarios y número de publicaciones:</h3>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Usuario: " . $row['nombre'] . ", Publicaciones: " . $row['num_publicaciones'] . "<br>";
    }

    // 2. Listar todas las publicaciones con el nombre del autor
    $sql = "SELECT p.titulo, u.nombre as autor, p.fecha_publicacion 
            FROM publicaciones p 
            INNER JOIN usuarios u ON p.usuario_id = u.id 
            ORDER BY p.fecha_publicacion DESC";

    $stmt = $pdo->query($sql);

    echo "<h3>Publicaciones con nombre del autor:</h3>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Título: " . $row['titulo'] . ", Autor: " . $row['autor'] . ", Fecha: " . $row['fecha_publicacion'] . "<br>";
    }

    // 3. Encontrar el usuario con más publicaciones
    $sql = "SELECT u.nombre, COUNT(p.id) as num_publicaciones 
            FROM usuarios u 
            LEFT JOIN publicaciones p ON u.id = p.usuario_id 
            GROUP BY u.id 
            ORDER BY num_publicaciones DESC 
            LIMIT 1";

    $stmt = $pdo->query($sql);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo "<h3>Usuario con más publicaciones:</h3>";
    
    echo "Nombre: " . $row['nombre'] . ", Número de publicaciones: " . $row['num_publicaciones'];
    

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
echo "<h2> Últimas 5 publicaciones</h2>";

$sql = "SELECT p.titulo, p.fecha_publicacion, u.nombre AS autor
        FROM publicaciones p
        INNER JOIN usuarios u ON p.usuario_id = u.id
        ORDER BY p.fecha_publicacion DESC
        LIMIT 5";

$stmt = $pdo->prepare($sql);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    echo "<table border='1'>
            <tr><th>Título</th><th>Autor</th><th>Fecha</th></tr>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>
                <td>{$row['titulo']}</td>
                <td>{$row['autor']}</td>
                <td>{$row['fecha_publicacion']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No hay publicaciones registradas.";
}

//Usuarios sin publicaciones
echo "<h2> Usuarios sin publicaciones</h2>";

$sql = "SELECT u.id, u.nombre, u.email
        FROM usuarios u
        LEFT JOIN publicaciones p ON u.id = p.usuario_id
        WHERE p.id IS NULL";

$stmt = $pdo->prepare($sql);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    echo "<ul>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<li>{$row['nombre']} ({$row['email']})</li>";
    }
    echo "</ul>";
} else {
    echo "Todos los usuarios tienen publicaciones.";
}

echo "<h2>Promedio de publicaciones por usuario</h2>";

$sql = "SELECT ROUND(COUNT(p.id) / COUNT(DISTINCT u.id), 2) AS promedio
        FROM usuarios u
        LEFT JOIN publicaciones p ON u.id = p.usuario_id";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$prom = $stmt->fetch(PDO::FETCH_ASSOC);

echo "Promedio: " . ($prom['promedio'] ?? 0);


// Publicación más reciente de cada usuario

echo "<h2> Publicación más reciente de cada usuario</h2>";

$sql = "SELECT u.nombre, p.titulo, p.fecha_publicacion
        FROM publicaciones p
        INNER JOIN usuarios u ON p.usuario_id = u.id
        INNER JOIN (
            SELECT usuario_id, MAX(fecha_publicacion) AS ultima_fecha
            FROM publicaciones
            GROUP BY usuario_id
        ) ult ON p.usuario_id = ult.usuario_id AND p.fecha_publicacion = ult.ultima_fecha
        ORDER BY u.nombre";

$stmt = $pdo->prepare($sql);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    echo "<table border='1'>
            <tr><th>Usuario</th><th>Publicación</th><th>Fecha</th></tr>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>
                <td>{$row['nombre']}</td>
                <td>{$row['titulo']}</td>
                <td>{$row['fecha_publicacion']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No se encontraron publicaciones recientes.";
}

unset($stmt);
unset($pdo);

$pdo = null;
?>