<?php
require_once 'Empresa.php';
require_once 'Gerente.php';
require_once 'Desarrollador.php';


$empresa = new Empresa("Tech Solutions");


$gerente1 = new Gerente("Ana López", "G001", 3000, "Ventas");
$gerente1->asignarBono(1200);

$gerente2 = new Gerente("Luis Martínez", "G002", 2800, "Marketing");
$gerente2->asignarBono(600);

$dev1 = new Desarrollador("Carlos Pérez", "D101", 2000, "PHP", "Senior");
$dev2 = new Desarrollador("María Gómez", "D102", 1800, "JavaScript", "Junior");
$dev3 = new Desarrollador("Jorge Ramírez", "D103", 2200, "Python", "Semi-Senior");


$empresa->agregarEmpleado($gerente1);
$empresa->agregarEmpleado($gerente2);
$empresa->agregarEmpleado($dev1);
$empresa->agregarEmpleado($dev2);
$empresa->agregarEmpleado($dev3);



echo "Empresa: " . $empresa->obtenerNombre() . "\n";



echo "Lista de empleados:\n";
$empresa->listarEmpleados();

echo "\nNómina total: " . $empresa->calcularTotalNomina() . " USD\n\n";


echo "Evaluación de desempeño:\n";
$empresa->evaluarDesempeno();
