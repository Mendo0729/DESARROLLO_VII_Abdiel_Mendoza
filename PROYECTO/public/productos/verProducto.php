<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../usuarios/login.php');
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('ID de producto no válido.');
}

require_once __DIR__ . '/../../src/controllers/ProductosController.php';

$controller = new ProductoController();
$producto = $controller->obtenerPorId((int)$_GET['id']);

if (!$producto) {
    die('Producto no encontrado.');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ver Producto</title>
</head>
<body>
    <h1>Detalles del Producto</h1>
    <p>Bienvenido, <?= htmlspecialchars($_SESSION['username']) ?></p>
    <a href="listarProductos.php">Volver a la lista de productos</a>
    <br><br>

    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th>
            <td><?= htmlspecialchars($producto->id) ?></td>
        </tr>
        <tr>
            <th>Nombre</th>
            <td><?= htmlspecialchars($producto->nombre) ?></td>
        </tr>
        <tr>
            <th>Precio</th>
            <td>$<?= number_format($producto->precio, 2) ?></td>
        </tr>
        <tr>
            <th>Descripción</th>
            <td><?= htmlspecialchars($producto->descripcion) ?></td>
        </tr>
        <tr>
            <th>Activo</th>
            <td><?= $producto->activo ? 'Sí' : 'No' ?></td>
        </tr>
    </table>
</body>
</html>
