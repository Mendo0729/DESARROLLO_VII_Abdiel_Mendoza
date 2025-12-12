<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../usuarios/login.php');
    exit;
}

require_once __DIR__ . '/../../src/controllers/ProductosController.php';

$controller = new ProductoController();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('ID de producto no válido.');
}

$id = (int)$_GET['id'];
$producto = $controller->obtenerPorId($id);

if (!$producto) {
    die('Producto no encontrado.');
}

$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'nombre' => $_POST['nombre'] ?? '',
        'precio' => $_POST['precio'] ?? 0,
        'descripcion' => $_POST['descripcion'] ?? '',
        'activo' => isset($_POST['activo']) ? 1 : 0
    ];

    $actualizado = $controller->actualizar($id, $data);

    if ($actualizado) {
        $mensaje = 'Producto actualizado correctamente.';
        $producto = $actualizado;
    } else {
        $mensaje = 'No se pudo actualizar el producto. Verifique los datos.';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
</head>
<body>
    <h1>Editar Producto</h1>
    <p>Bienvenido, <?= htmlspecialchars($_SESSION['username']) ?></p>
    <a href="listarProductos.php">Volver a la lista de productos</a>
    <br><br>

    <?php if ($mensaje): ?>
        <p><?= htmlspecialchars($mensaje) ?></p>
    <?php endif; ?>

    <form method="post">
        <label>Nombre:</label><br>
        <input type="text" name="nombre" value="<?= htmlspecialchars($producto->nombre) ?>" required><br><br>

        <label>Precio:</label><br>
        <input type="number" step="0.01" name="precio" value="<?= htmlspecialchars($producto->precio) ?>" required><br><br>

        <label>Descripción:</label><br>
        <textarea name="descripcion"><?= htmlspecialchars($producto->descripcion) ?></textarea><br><br>

        <label>Activo:</label>
        <input type="checkbox" name="activo" <?= $producto->activo ? 'checked' : '' ?>><br><br>

        <button type="submit">Actualizar Producto</button>
    </form>
</body>
</html>
