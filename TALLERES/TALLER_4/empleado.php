<?php
class Empleado {
    public $nombre;
    public $id;
    public $salario;

    public function __construct($nombre, $id, $salario) {
        $this->nombre = $nombre;
        $this->id = $id;
        $this->salario = $salario;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getSalario() {
        return $this->salario;
    }
}
