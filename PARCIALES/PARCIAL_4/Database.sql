CREATE DATABASE techparts_db;
/*  */
USE techparts_db;
/*  */
CREATE TABLE productos (
id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
nombre VARCHAR(120) NOT NULL,
categoria VARCHAR(80) NOT NULL,
precio DOUBLE(10,2),
cantidad INT,
fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);