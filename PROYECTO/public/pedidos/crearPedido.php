<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../usuarios/login.php');
    exit;
}

require_once __DIR__ . '/../../src/controllers/PedidoController.php';
require_once __DIR__ . '/../../src/controllers/ClienteController.php';
require_once __DIR__ . '/../../src/controllers/ProductosController.php';

$pedidoController = new PedidoController();
$clienteController = new ClienteController();
$productoController = new ProductoController();

$clientes = $clienteController->obtenerTodos();
$productos = $productoController->obtenerTodos();

$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cliente_id = (int)($_POST['cliente_id'] ?? 0);
    $fecha_entrega = $_POST['fecha_entrega'] ?? null;
    $productos_post = $_POST['productos'] ?? [];

    $items = [];
    foreach ($productos_post as $p) {
        $items[] = [
            'producto_id' => (int)$p['producto_id'],
            'cantidad' => (int)$p['cantidad']
        ];
    }

    $pedido = $pedidoController->crear($cliente_id, $items, $fecha_entrega);
    if ($pedido) {
        $mensaje = "Pedido creado con éxito. ID: {$pedido->id}";
    } else {
        $mensaje = "Error al crear el pedido.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Pedido</title>
</head>
<body>
<h1>Crear Pedido</h1>
<p>Bienvenido, <?= htmlspecialchars($_SESSION['username']) ?></p>
<a href="../dashboard.php">Volver al Dashboard</a>
<br><br>

<?php if ($mensaje): ?>
    <p><strong><?= htmlspecialchars($mensaje) ?></strong></p>
<?php endif; ?>

<form method="POST">
    <label>Cliente:</label>
    <select name="cliente_id" required>
        <option value="">--Seleccione--</option>
        <?php foreach ($clientes as $cliente): ?>
            <option value="<?= $cliente->id ?>"><?= htmlspecialchars($cliente->nombre) ?></option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <label>Fecha de entrega:</label>
    <input type="date" name="fecha_entrega" required>
    <br><br>

    <h3>Productos:</h3>
    <div id="productos-container">
        <div class="producto-item">
            <select name="productos[0][producto_id]" required>
                <option value="">--Seleccione producto--</option>
                <?php foreach ($productos as $producto): ?>
                    <option value="<?= $producto->id ?>"><?= htmlspecialchars($producto->nombre) ?> - $<?= $producto->precio ?></option>
                <?php endforeach; ?>
            </select>
            <input type="number" name="productos[0][cantidad]" min="1" value="1" required>
        </div>
    </div>
    <br>
    <button type="button" onclick="agregarProducto()">Agregar otro producto</button>
    <br><br>
    <button type="submit">Crear Pedido</button>
</form>

<script>
let contador = 1;
function agregarProducto() {
    const container = document.getElementById('productos-container');
    const div = document.createElement('div');
    div.classList.add('producto-item');
    div.innerHTML = `
        <select name="productos[${contador}][producto_id]" required>
            <option value="">--Seleccione producto--</option>
            <?php foreach ($productos as $producto): ?>
                <option value="<?= $producto->id ?>"><?= htmlspecialchars($producto->nombre) ?> - $<?= $producto->precio ?></option>
            <?php endforeach; ?>
        </select>
        <input type="number" name="productos[${contador}][cantidad]" min="1" value="1" required>
    `;
    container.appendChild(div);
    contador++;
}
</script>
</body>
</html>