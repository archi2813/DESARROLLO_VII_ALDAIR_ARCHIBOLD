<?php
require_once 'empleado.php';
require_once 'Evaluable.php';

class Gerente extends Empleado implements Evaluable {
	public $departamento;

	public function __construct($nombre, $id, $salario, $departamento) {
		parent::__construct($nombre, $id, $salario);
		$this->departamento = $departamento;
	}

	public function getDepartamento() {
		return $this->departamento;
	}

	public function setDepartamento($departamento) {
		$this->departamento = $departamento;
	}

	public function asignarBono($monto) {
		$this->salario += $monto;
		return "Bono de $monto asignado a {$this->nombre}. Nuevo salario: {$this->salario}";
	}

	// Lógica personalizada para Gerente
	public function evaluarDesempenio() {
		// Ejemplo: Si el salario es mayor a 5000 y el departamento tiene más de 10 empleados
		// (Simulación, ya que no hay empleados en el departamento)
		if ($this->salario > 5000) {
			return "Desempeño excelente como gerente del departamento {$this->departamento}.";
		} else {
			return "Desempeño satisfactorio como gerente del departamento {$this->departamento}.";
		}
	}
}