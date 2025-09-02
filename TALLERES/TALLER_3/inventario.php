<?php
// Carga todo el inventario desde inventario.json
function cargarInventario($archivo)
{
    if (!file_exists($archivo)) {
        return [];
    }
    $contenido = file_get_contents($archivo);
    return json_decode($contenido, true);
}

// inventario acomodado alfabeticamente
function mostrarInventario($inventario)
{
    // Ordenado por nombre
    usort($inventario, function ($a, $b) {
        return strcmp($a['nombre'], $b['nombre']);
    });

    echo "<h2>Resumen del inventario</h2>";
    echo "<table border='1' cellpadding='8' cellspacing='0' style='border-collapse:collapse; text-align:center;'>";
    echo "<tr style='background:#f2f2f2;'>
            <th>Producto</th>
            <th>Precio (USD)</th>
            <th>Cantidad</th>
          </tr>";
    foreach ($inventario as $producto) {
        echo "<tr>
                <td>{$producto['nombre']}</td>
                <td>$" . number_format($producto['precio'], 2) . "</td>
                <td>{$producto['cantidad']}</td>
              </tr>";
    }
    echo "</table>";
    return $inventario;
}

// calcular el valor total 
function calcularValorTotal($inventario)
{
    $valores = array_map(function ($producto) {
        return $producto['precio'] * $producto['cantidad'];
    }, $inventario);

    $total = array_sum($valores);

    echo "<h2>Valor total del inventario: $" . number_format($total, 2) . "</h2>";
    return $total;
}

// generacion de informes de stock bajo
function informeStockBajo($inventario, $limite)
{
    $stockBajo = array_filter($inventario, function ($producto) use ($limite) {
        return $producto['cantidad'] < $limite;
    });

    echo "<h2>Productos con stock bajo (menos de $limite)</h2>";

    if (count($stockBajo) === 0) {
        echo "Todos los productos tienen suficiente stock.<br>";
    } else {
        echo "<ul>";
        foreach ($stockBajo as $producto) {
            echo "<li><b>{$producto['nombre']}</b> | Cantidad: {$producto['cantidad']}</li>";
        }
        echo "</ul>";
    }
}


$archivo = "inventario.json";
$inventario = cargarInventario($archivo);

echo "<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <title>Gestión de Inventario</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h2 { color: #333; }
        table { width: 60%; margin-bottom: 20px; }
        th, td { padding: 8px; }
        th { background-color: #ddd; }
    </style>
</head>
<body>";

$inventarioOrdenado = mostrarInventario($inventario);
calcularValorTotal($inventarioOrdenado);
informeStockBajo($inventarioOrdenado, 5);

echo "</body></html>";
