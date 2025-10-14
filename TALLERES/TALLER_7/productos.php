<?php
require_once 'config_sesion.php';
$catalogo = get_productos_catalogo();
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Productos - Tienda</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <style>
        body{font-family:Arial,Helvetica,sans-serif;max-width:900px;margin:1rem auto;padding:0 1rem}
        .producto{border:1px solid #ddd;padding:10px;margin-bottom:10px;border-radius:6px}
        .acciones{margin-top:8px}
        .nav{margin-bottom:12px}
    </style>
</head>
<body>
    <div class="nav">
        <a href="productos.php">Productos</a> | <a href="ver_carrito.php">Ver carrito (<?php echo array_sum($_SESSION['carrito'] ?? []); ?>)</a>
    </div>

    <h1>Catálogo de productos</h1>

    <?php foreach ($catalogo as $id => $p): ?>
        <div class="producto">
            <?php// print_r($id)?>
            <strong><?php echo htmlspecialchars($p['nombre']); ?></strong>
            <div>Precio: $<?php echo number_format($p['precio'], 2); ?></div>
            <div class="acciones">
                <form action="agregar_al_carrito.php" method="post" style="display:inline-block">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="id" value="<?php echo (int)$id; ?>">
                    Cantidad: <input type="number" name="cantidad" value="1" min="1" style="width:60px">
                    <button type="submit">Añadir al carrito</button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>

</body>
</html>