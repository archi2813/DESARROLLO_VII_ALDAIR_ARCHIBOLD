<?php
class GestorProductos {
    private $productos = [];
    private $archivo = 'productos.json';

    public function __construct() {
        $this->cargarProductos();
    }

    private function cargarProductos() {
        if (file_exists($this->archivo)) {
            $contenido = file_get_contents($this->archivo);
            $this->productos = json_decode($contenido, true);
        }
    }

    public function obtenerProductos() {
        return $this->productos;
    }
}   
//session_start();
?>
