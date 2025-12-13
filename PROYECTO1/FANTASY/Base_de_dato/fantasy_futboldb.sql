-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         8.4.3 - MySQL Community Server - GPL
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Volcando estructura para tabla fantasy_futbol.equipos
CREATE TABLE IF NOT EXISTS `equipos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int NOT NULL,
  `nombre_equipo` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `equipos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla fantasy_futbol.equipos: ~0 rows (aproximadamente)
INSERT INTO `equipos` (`id`, `usuario_id`, `nombre_equipo`) VALUES
	(1, 4, 'Mi Equipo'),
	(2, 3, 'Mi Equipo');

-- Volcando estructura para tabla fantasy_futbol.equipo_jugadores
CREATE TABLE IF NOT EXISTS `equipo_jugadores` (
  `equipo_id` int NOT NULL,
  `jugador_id` int NOT NULL,
  PRIMARY KEY (`equipo_id`,`jugador_id`),
  KEY `jugador_id` (`jugador_id`),
  CONSTRAINT `equipo_jugadores_ibfk_1` FOREIGN KEY (`equipo_id`) REFERENCES `equipos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `equipo_jugadores_ibfk_2` FOREIGN KEY (`jugador_id`) REFERENCES `jugadores` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla fantasy_futbol.equipo_jugadores: ~0 rows (aproximadamente)
INSERT INTO `equipo_jugadores` (`equipo_id`, `jugador_id`) VALUES
	(1, 1),
	(1, 39),
	(1, 43);

-- Volcando estructura para tabla fantasy_futbol.jugadores
CREATE TABLE IF NOT EXISTS `jugadores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `posicion` enum('Portero','Defensa','Centrocampista','Delantero') NOT NULL,
  `equipo` varchar(50) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `puntos` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla fantasy_futbol.jugadores: ~0 rows (aproximadamente)
INSERT INTO `jugadores` (`id`, `nombre`, `posicion`, `equipo`, `precio`, `puntos`) VALUES
	(1, 'Lionel Messi', 'Delantero', 'Inter Miami', 50.00, 101),
	(38, 'Lionel Messi', 'Delantero', 'Inter Miami', 120.00, 0),
	(39, 'Cristiano Ronaldo', 'Delantero', 'Al Nassr', 115.00, 0),
	(40, 'Kylian Mbappé', 'Delantero', 'PSG', 110.00, 0),
	(41, 'Kevin De Bruyne', 'Centrocampista', 'Manchester City', 95.00, 0),
	(42, 'Luka Modric', 'Centrocampista', 'Real Madrid', 85.00, 0),
	(43, 'Virgil van Dijk', 'Defensa', 'Liverpool', 80.00, 0),
	(44, 'Sergio Ramos', 'Defensa', 'Sevilla', 75.00, 0),
	(45, 'Marc-André ter Stegen', 'Portero', 'Barcelona', 100.00, 80),
	(46, 'Thibaut Courtois', 'Portero', 'Real Madrid', 72.00, 0),
	(47, 'Erling Haaland', 'Delantero', 'Manchester City', 130.00, 0);

-- Volcando estructura para tabla fantasy_futbol.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `saldo` decimal(10,2) DEFAULT '100.00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla fantasy_futbol.usuarios: ~0 rows (aproximadamente)
INSERT INTO `usuarios` (`id`, `nombre`, `email`, `password_hash`, `saldo`) VALUES
	(1, 'Juan Pérez', 'juan.perez@example.com', '$2y$10$osLa5LOyMxPuKwIpXae5cOjHZPdvTm1a4GWYXsjUR9vfsOnGmUCp2', 150.75),
	(2, 'María López', 'maria.lopez@example.com', '$2y$10$RQNDvNK.SVPIeY1wLh/8V.vhkOBYJ5Hl3w5YJiwLm7ZcPZMOJuHv.', 200.00),
	(3, 'Carlos Gómez', 'carlos.gomez@example.com', '$2y$10$6XFL8glnQf.ZpQ02zVdmNOzZhBXeKHl7edJRnfAgN.QBSeEYododC', 120.50),
	(4, 'Ana Torres', 'ana.torres@example.com', '$2y$10$AArvBWzZF0qrFX9YnxIp../Z/TfqSnw2E0J1sfQBXVDZev9DjvQeu', 55.00),
	(5, 'Luis Fernández', 'luis.fernandez@example.com', '$2y$10$F0v30LFVfaO0Tkl5FfQfgedYXkBiMVBFMqapKxE4bGx9V4hWoFWva', 100.00);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
