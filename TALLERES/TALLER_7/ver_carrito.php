<?php
require_once 'config_sesion.php';
$catalogo = get_productos_catalogo();
$carrito = $_SESSION['carrito'] ?? [];

function calcular_total($carrito, $catalogo) {
    $total = 0.0;
    foreach ($carrito as $id => $cant) {
        if (isset($catalogo[$id])) {
            $total += $catalogo[$id]['precio'] * $cant;
        }
    }
    return $total;
}

?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Carrito</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <style>body{font-family:Arial,Helvetica,sans-serif;max-width:900px;margin:1rem auto;padding:0 1rem}.actions{margin-top:10px}</style>
</head>
<body>
    <div><a href="productos.php">Seguir comprando</a></div>
    <h1>Tu carrito</h1>

    <?php if (empty($carrito)): ?>
        <p>El carrito está vacío.</p>
    <?php else: ?>
        <form action="eliminar_del_carrito.php" method="post">
            <?php echo csrf_field(); ?>
            <table border="0" cellpadding="6" cellspacing="0">
                <tr><th>Producto</th><th>Precio</th><th>Cantidad</th><th>Subtotal</th><th>Acción</th></tr>
                <?php foreach ($carrito as $id => $cant): 
                    if (!isset($catalogo[$id])) continue;
                    $prod = $catalogo[$id];
                    $subtotal = $prod['precio'] * $cant;
                ?>
                <tr>
                    <?php// print_r($id)?>
                    <td><?php echo htmlspecialchars($prod['nombre']); ?></td>
                    <td>$<?php echo number_format($prod['precio'],2); ?></td>
                    <td><?php echo (int)$cant; ?></td>
                    <td>$<?php echo number_format($subtotal,2); ?></td>
                    <td>
                        <button name="eliminar_id" value="<?php echo (int)$id; ?>">Eliminar</button>
                    </td>
                </tr>
                <?php endforeach; ?>
                <tr><td colspan="3" align="right"><strong>Total:</strong></td><td colspan="2">$<?php echo number_format(calcular_total($carrito,$catalogo),2); ?></td></tr>
            </table>
        </form>

        <div class="actions">
            <form action="checkout.php" method="post" style="display:inline-block">
                <?php echo csrf_field(); ?>
                Nombre para el recibo (opcional): <input type="text" name="nombre" maxlength="100">
                <button type="submit">Finalizar compra</button>
            </form>
        </div>
    <?php endif; ?>

</body>
</html>
