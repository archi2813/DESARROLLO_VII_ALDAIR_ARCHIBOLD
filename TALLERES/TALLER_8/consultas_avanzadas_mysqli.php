<?php
require_once "config_mysqli.php";

// 1. Mostrar todos los usuarios junto con el número de publicaciones que han hecho
$sql = "SELECT u.id, u.nombre, COUNT(p.id) as num_publicaciones 
        FROM usuarios u 
        LEFT JOIN publicaciones p ON u.id = p.usuario_id 
        GROUP BY u.id";

$result = mysqli_query($conn, $sql);

if ($result) {
    echo "<h3>Usuarios y número de publicaciones:</h3>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "Usuario: " . $row['nombre'] . ", Publicaciones: " . $row['num_publicaciones'] . "<br>";
    }
    mysqli_free_result($result);
} else {
    echo "Error: " . mysqli_error($conn);
}

// 2. Listar todas las publicaciones con el nombre del autor
$sql = "SELECT p.titulo, u.nombre as autor, p.fecha_publicacion 
        FROM publicaciones p 
        INNER JOIN usuarios u ON p.usuario_id = u.id 
        ORDER BY p.fecha_publicacion DESC";

$result = mysqli_query($conn, $sql);

if ($result) {
    echo "<h3>Publicaciones con nombre del autor:</h3>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "Título: " . $row['titulo'] . ", Autor: " . $row['autor'] . ", Fecha: " . $row['fecha_publicacion'] . "<br>";
    }
    mysqli_free_result($result);
} else {
    echo "Error: " . mysqli_error($conn);
}

// 3. Encontrar el usuario con más publicaciones
$sql = "SELECT u.nombre, COUNT(p.id) as num_publicaciones 
        FROM usuarios u 
        LEFT JOIN publicaciones p ON u.id = p.usuario_id 
        GROUP BY u.id 
        ORDER BY num_publicaciones DESC 
        LIMIT 1";

$result = mysqli_query($conn, $sql);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    echo "<h3>Usuario con más publicaciones:</h3>";
    echo "Nombre: " . $row['nombre'] . ", Número de publicaciones: " . $row['num_publicaciones'];
    mysqli_free_result($result);
} else {
    echo "Error: " . mysqli_error($conn);
}

//Últimas 5 publicaciones

echo "<h2> Últimas 5 publicaciones</h2>";

$sql = "SELECT p.titulo, p.fecha_publicacion, u.nombre AS autor
        FROM publicaciones p
        INNER JOIN usuarios u ON p.usuario_id = u.id
        ORDER BY p.fecha_publicacion DESC
        LIMIT 5";

if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        echo "<table border='1'>
                <tr><th>Título</th><th>Autor</th><th>Fecha</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
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
    mysqli_stmt_close($stmt);
}

//Usuarios sin publicaciones

echo "<h2> Usuarios sin publicaciones</h2>";

$sql = "SELECT u.id, u.nombre, u.email
        FROM usuarios u
        LEFT JOIN publicaciones p ON u.id = p.usuario_id
        WHERE p.id IS NULL";

if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        echo "<ul>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<li>{$row['nombre']} ({$row['email']})</li>";
        }
        echo "</ul>";
    } else {
        echo "Todos los usuarios tienen publicaciones.";
    }
    mysqli_stmt_close($stmt);
}


//Promedio de publicaciones por usuario

echo "<h2> Promedio de publicaciones por usuario</h2>";

$sql = "SELECT ROUND(COUNT(p.id) / COUNT(DISTINCT u.id), 2) AS promedio
        FROM usuarios u
        LEFT JOIN publicaciones p ON u.id = p.usuario_id";

if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    echo "Promedio: " . ($row['promedio'] ?? 0);
    mysqli_stmt_close($stmt);
}

//Publicación más reciente de cada usuario
echo "<h2>Publicación más reciente de cada usuario</h2>";

$sql = "SELECT u.nombre, p.titulo, p.fecha_publicacion
        FROM publicaciones p
        INNER JOIN usuarios u ON p.usuario_id = u.id
        INNER JOIN (
            SELECT usuario_id, MAX(fecha_publicacion) AS ultima_fecha
            FROM publicaciones
            GROUP BY usuario_id
        ) ult ON p.usuario_id = ult.usuario_id AND p.fecha_publicacion = ult.ultima_fecha
        ORDER BY u.nombre";

if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        echo "<table border='1'>
                <tr><th>Usuario</th><th>Publicación</th><th>Fecha</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
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
    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>