<?php
require_once 'Empresa.php';
require_once 'Gerente.php';
require_once 'Desarrollador.php';

$empresa = new Empresa();

// Crear empleados
$gerente = new Gerente("Ana", 1, 7000, "Ventas");
$desarrollador1 = new Desarrollador("Luis", 2, 4500, "PHP", "Senior");
$desarrollador2 = new Desarrollador("Marta", 3, 3500, "JavaScript", "Junior");

// Agregar empleados
$empresa->agregarEmpleado($gerente);
$empresa->agregarEmpleado($desarrollador1);
$empresa->agregarEmpleado($desarrollador2);

// Listar empleados
echo "Lista de empleados:\n";
$empresa->listarEmpleados();

// Calcular nómina total
echo "\nNómina total: " . $empresa->calcularNominaTotal() . "\n";

// Evaluar desempeño
echo "\nEvaluación de desempeño:\n";
$empresa->evaluarDesempenioEmpleados();

// Asignar bono al gerente
echo "\n" . $gerente->asignarBono(1000) . "\n";

// Mostrar nómina actualizada
echo "\nNómina total actualizada: " . $empresa->calcularNominaTotal() . "\n";
