
<?php
require_once 'empleado.php';
require_once 'Evaluable.php';

class Desarrollador extends Empleado implements Evaluable {
	public $lenguajePrincipal;
	public $nivelExperiencia;

	public function __construct($nombre, $id, $salario, $lenguajePrincipal, $nivelExperiencia) {
		parent::__construct($nombre, $id, $salario);
		$this->lenguajePrincipal = $lenguajePrincipal;
		$this->nivelExperiencia = $nivelExperiencia;
	}

	public function getLenguajePrincipal() {
		return $this->lenguajePrincipal;
	}

	public function setLenguajePrincipal($lenguaje) {
		$this->lenguajePrincipal = $lenguaje;
	}

	public function getNivelExperiencia() {
		return $this->nivelExperiencia;
	}

	public function setNivelExperiencia($nivel) {
		$this->nivelExperiencia = $nivel;
	}

	// Lógica personalizada para Desarrollador
	public function evaluarDesempenio() {
		// Ejemplo: Si el nivel de experiencia es "Senior" y el lenguaje es "PHP"
		if (strtolower($this->nivelExperiencia) === "senior") {
			return "Desempeño sobresaliente como desarrollador {$this->lenguajePrincipal}.";
		} else {
			return "Desempeño adecuado como desarrollador {$this->lenguajePrincipal}.";
		}
	}
}
