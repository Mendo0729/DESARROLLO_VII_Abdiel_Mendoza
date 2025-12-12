<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../usuarios/login.php');
    exit;
}

require_once __DIR__ . '/../../src/controllers/ProductosController.php';

$controller = new ProductoController();
$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $precio = $_POST['precio'] ?? 0;
    $descripcion = $_POST['descripcion'] ?? '';

    $producto = $controller->crear([
        'nombre' => $nombre,
        'precio' => $precio,
        'descripcion' => $descripcion
    ]);

    if ($producto) {
        $mensaje = "Producto creado exitosamente.";
    } else {
        $mensaje = "Error: No se pudo crear el producto. Verifica los datos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Producto</title>
</head>
<body>
    <h1>Crear Producto</h1>
    <p>Bienvenido, <?= htmlspecialchars($_SESSION['username']) ?></p>
    <a href="listarProductos.php">Volver a la lista de productos</a>
    <br><br>
    
    <?php if ($mensaje): ?>
        <p><?= htmlspecialchars($mensaje) ?></p>
    <?php endif; ?>
    
    <form method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" required><br><br>

        <label for="precio">Precio:</label>
        <input type="number" step="0.01" name="precio" id="precio" required><br><br>

        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" id="descripcion"></textarea><br><br>

        <button type="submit">Crear Producto</button>
    </form>
</body>
</html>
