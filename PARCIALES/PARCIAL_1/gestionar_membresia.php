<?php

require_once 'funciones_gimnasio.php';

$precioBase = [
    'basica' => 80,
    'premium' => 120,
    'vip' => 180,
    'familiar' => 250,
    'corporativa' => 300
];

$mienbros = [
    'Juan Linares'   => ['tipo'=> 'premium', 'antiguedad' => 20],
    'Abdiel Mendoza' => ['tipo'=> 'corporativa', 'antiguedad' => 2],
    'Maria Becerra'  => ['tipo'=> 'basica', 'antiguedad' => 7],
    'Marcelo Espieno' => ['tipo'=> 'vip', 'antiguedad' => 15],
    'Lius Fuentes'    => ['tipo'=> 'familiar', 'antiguedad' => 10],
    'Ana Torres'      => ['tipo'=> 'premium', 'antiguedad' => 25],
    'Carlos Vela'     => ['tipo'=> 'basica', 'antiguedad' => 5],
    'Sofia Vergara'   => ['tipo'=> 'vip', 'antiguedad' => 30]
];

$cuotabase = 0;
$descuento = 0;
$seguromedico = 0;
$total = 0;
foreach($mienbros as $nombre => $datos){

    $cuotabase = $precioBase[$datos['tipo']];
    $descuento = calcular_descuento($datos['antiguedad']);
    $seguromedico = calcular_seguro_medico($cuotabase);
    $total = calcular_total($cuotabase, $descuento, $seguromedico);
    $mienbros[$nombre]['cuotabase'] = $cuotabase;
    $mienbros[$nombre]['descuento'] = $descuento;
    $mienbros[$nombre]['seguromedico'] = $seguromedico;
    $mienbros[$nombre]['total'] = $total;

}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestion de Membresías</title>
    <style>
        table { border-collapse: collapse; width: 50%; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background: #eee; }
    </style>
</head>
<body>
    <h2>Resumen de Membresías</h2>
    <table>
        <tr>
            <th>Nombre</th>
            <th>Membresía</th>
            <th>Cuota Base</th>
            <th>Seguro Medico</th>
            <th>Descuento aplicado(%)</th>
            <th>Total a Pagar</th>
        </tr>
        <?php foreach($mienbros as $nombre => $datos): ?>
            <tr>
                <td><?=$nombre ?></td>
                <td><?=$datos['tipo'] ?></td>
                <td>$<?= number_format($datos['cuotabase'], 2) ?></td>
                <td>$<?= number_format($datos['seguromedico'], 2) ?></td>
                <td><?= $datos['descuento'] ?>%</td>
                <td>$<?= number_format($datos['total'], 2) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>