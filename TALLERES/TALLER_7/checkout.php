<?php
require_once 'config_sesion.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ver_carrito.php');
    exit;
}
check_csrf();

$catalogo = get_productos_catalogo();
$carrito = $_SESSION['carrito'] ?? [];
if (empty($carrito)) {
    $_SESSION['error'] = 'El carrito está vacío.';
    header('Location: ver_carrito.php');
    exit;
}

$items = [];
$total = 0.0;
foreach ($carrito as $id => $cant) {
    if (!isset($catalogo[$id])) continue;
    $nombre = $catalogo[$id]['nombre'];
    $precio = $catalogo[$id]['precio'];
    $subtotal = $precio * $cant;
    $items[] = ['id' => $id, 'nombre' => $nombre, 'cantidad' => $cant, 'precio' => $precio, 'subtotal' => $subtotal];
    $total += $subtotal;
}


if (!empty($_POST['nombre'])) {
    $nombre_limpio = trim($_POST['nombre']);
    setcookie('tienda_nombre_usuario', $nombre_limpio, [
        'expires' => time() + 86400,
        'path' => '/',
        'httponly' => true,
        'secure' => false,
        'samesite' => 'Lax'
    ]);
}

$_SESSION['carrito'] = [];

?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Resumen de compra</title>
</head>
<body>
    <h1>Gracias por tu compra</h1>
    <?php if (!empty($nombre_limpio)): ?>
        <p>Gracias, <?php echo htmlspecialchars($nombre_limpio); ?>. Se ha guardado tu nombre en una cookie por 24 horas.</p>
    <?php endif; ?>
    <h2>Resumen</h2>
    <table cellpadding="6" cellspacing="0">
        <tr><th>Producto</th><th>Precio</th><th>Cantidad</th><th>Subtotal</th></tr>
        <?php foreach ($items as $it): ?>
            <tr>
                <td><?php echo htmlspecialchars($it['nombre']); ?></td>
                <td>$<?php echo number_format($it['precio'],2); ?></td>
                <td><?php echo (int)$it['cantidad']; ?></td>
                <td>$<?php echo number_format($it['subtotal'],2); ?></td>
            </tr>
        <?php endforeach; ?>
        <tr><td colspan="3" align="right"><strong>Total:</strong></td><td>$<?php echo number_format($total,2); ?></td></tr>
    </table>

    <p><a href="productos.php">Volver al catálogo</a></p>
</body>
</html>
