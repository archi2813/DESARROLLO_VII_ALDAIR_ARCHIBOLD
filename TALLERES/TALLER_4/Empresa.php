<?php
require_once 'Gerente.php';
require_once 'Desarrollador.php';
require_once 'Evaluable.php';

class Empresa {
	private $empleados = [];

	public function agregarEmpleado($empleado) {
		$this->empleados[] = $empleado;
	}

	public function listarEmpleados() {
		foreach ($this->empleados as $empleado) {
			echo get_class($empleado) . ': ' . $empleado->getNombre() . " | ID: " . $empleado->getId() . " | Salario: " . $empleado->getSalario() . "\n";
		}
	}

	public function calcularNominaTotal() {
		$total = 0;
		foreach ($this->empleados as $empleado) {
			$total += $empleado->getSalario();
		}
		return $total;
	}

	public function evaluarDesempenioEmpleados() {
		foreach ($this->empleados as $empleado) {
			if ($empleado instanceof Evaluable) {
				echo $empleado->evaluarDesempenio() . "\n";
			}
		}
	}
}