<?php
require_once 'Empresa.php';

$empresa = new Empresa();

$g1 = new Gerente('Ana López', 1001, 4500.00, 'Ventas');
$g1->asignarBono(2000.00);

$d1 = new Desarrollador('Carlos Pérez', 2001, 3200.00, 'PHP', 'senior');
$d2 = new Desarrollador('María Ruiz', 2002, 2200.00, 'JavaScript', 'junior');

$empresa->agregarEmpleado($g1);
$empresa->agregarEmpleado($d1);
$empresa->agregarEmpleado($d2);

echo "Listado de empleados:\n";
foreach ($empresa->listarEmpleados() as $e) {
    echo "- [" . get_class($e) . "] ID: " . $e->getIdEmpleado() . " Nombre: " . $e->getNombre() . " Salario: " . number_format($e->getSalarioBase(), 2) . "\n";
}

echo "\nNómina total antes de aumentos: " . number_format($empresa->calcularNominaTotal(), 2) . "\n";

$resultados = $empresa->evaluarDesempenoTodos(true);

echo "\nResultados de evaluación (ID => score):\n";
foreach ($resultados as $id => $score) {
    echo "$id => $score\n";
}

echo "\nNómina total después de aumentos: " . number_format($empresa->calcularNominaTotal(), 2) . "\n";

$empresa->guardarEnArchivo('empleados.json');
